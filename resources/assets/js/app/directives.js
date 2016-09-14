'use strict';

angular.module('app.directives', [])
    .directive('appInclude', ['$templateRequest', '$anchorScroll', '$animate', function ($templateRequest, $anchorScroll, $animate) {
        return {
            restrict: 'ECA',
            priority: 400,
            terminal: true,
            transclude: 'element',
            controller: angular.noop,
            compile: function (element, attr) {
                var srcExp = attr.appInclude || attr.src,
                    onloadExp = attr.onload || '',
                    onfailExp = attr.onfail || '',
                    autoScrollExp = attr.autoscroll;

                return function (scope, $element, $attr, ctrl, $transclude) {
                    var changeCounter = 0,
                        currentScope,
                        previousElement,
                        currentElement;

                    var cleanupLastIncludeContent = function () {
                        if (previousElement) {
                            previousElement.remove();
                            previousElement = null;
                        }
                        if (currentScope) {
                            currentScope.$destroy();
                            currentScope = null;
                        }
                        if (currentElement) {
                            $animate.leave(currentElement).then(function () {
                                previousElement = null;
                            });
                            previousElement = currentElement;
                            currentElement = null;
                        }
                    };

                    scope.$watch(srcExp, function ngIncludeWatchAction(src) {
                        var afterAnimation = function () {
                            if (angular.isDefined(autoScrollExp) && (!autoScrollExp || scope.$eval(autoScrollExp))) {
                                $anchorScroll();
                            }
                        };
                        var thisChangeId = ++changeCounter;

                        if (src) {
                            //set the 2nd param to true to ignore the template request error so that the inner
                            //contents and scope can be cleaned up.
                            $templateRequest(src, true).then(function (response) {
                                if (scope.$$destroyed) return;

                                if (thisChangeId !== changeCounter) return;
                                var newScope = scope.$new();
                                ctrl.template = response;

                                // Note: This will also link all children of ng-include that were contained in the original
                                // html. If that content contains controllers, ... they could pollute/change the scope.
                                // However, using ng-include on an element with additional content does not make sense...
                                // Note: We can't remove them in the cloneAttchFn of $transclude as that
                                // function is called before linking the content, which would apply child
                                // directives to non existing elements.
                                var clone = $transclude(newScope, function (clone) {
                                    cleanupLastIncludeContent();
                                    $animate.enter(clone, null, $element).then(afterAnimation);
                                });

                                currentScope = newScope;
                                currentElement = clone;

                                currentScope.$emit('$includeContentLoaded', src);
                                scope.$eval(onloadExp);
                            }, function (response) {
                                if (scope.$$destroyed) return;

                                if (thisChangeId === changeCounter) {
                                    cleanupLastIncludeContent();
                                    scope.$emit('$includeContentError', src);
                                    scope.$eval(onfailExp)(response);
                                }
                            });
                            scope.$emit('$includeContentRequested', src);
                        } else {
                            cleanupLastIncludeContent();
                            ctrl.template = null;
                        }
                    });
                };
            }
        };
    }])
    .directive('appInclude', ['$compile', function ($compile) {
        return {
            restrict: 'ECA',
            priority: -400,
            require: 'appInclude',
            link: function (scope, $element, $attr, ctrl) {
                if (toString.call($element[0]).match(/SVG/)) {
                    $element.empty();
                    $compile(jqLiteBuildFragment(ctrl.template, window.document).childNodes)(
                        scope,
                        function namespaceAdaptedClone(clone) {
                            $element.append(clone);
                        },
                        {futureParentElement: $element});
                    return;
                }

                $element.html(ctrl.template);
                $compile($element.contents())(scope);
            }
        };
    }])
    .directive('appMenu', ['$filter', function ($filter) {
        return {
            template: `
<ul class="sidebar-menu">
    <li ng-class="{'header':!menu.name, 'treeview': menu.children}" ng-repeat="menu in menus">
        {{!menu.name ? menu.group : ''}}

        <a ng-href="{{ menu.url || '#' | url }}" ng-if="menu.name">
            <i class="{{menu.icon}}" ng-if="menu.icon"></i>
            <span>{{menu.name}}</span>
            <span class="pull-right-container" ng-if="menu.children || menu.right">
                <small class="label pull-right {{right.class}}" ng-repeat="right in menu.right">{{right.text}}</small>
                <i class="fa fa-angle-left pull-right" ng-if="menu.children && !menu.right"></i>
            </span>
        </a>

        <app-menu-child children="menu.children" ng-if="menu.children"></app-menu-child>

    </li>
</ul>
`,
            replace: true,
            scope: {
                items: '=',
                filter: '@'
            },
            link: function (scope, element, attributes) {
                let [group, filter] = [$filter('menuGroup'), $filter('menuFilter')];

                scope.menus = [];

                scope.$watchCollection('items', () => {
                    scope.menus = group(filter(scope.items, scope.filter));
                });

                scope.$watch('filter', () => {
                    scope.menus = group(filter(scope.items, scope.filter));
                });
            }
        };
    }])
    .directive('appMenuChild', function () {
        return {
            template: `
<ul class="treeview-menu">
    <li ng-repeat="menu in children" ng-class="{'treeview': menu.children}">

        <a ng-href="{{ menu.url || '#' | url }}">
            <i class="{{menu.icon}}" ng-if="menu.icon"></i>
            {{menu.name}}
            <span class="pull-right-container" ng-if="menu.children || menu.right">
                <small class="label pull-right {{right.class}}" ng-repeat="right in menu.right">{{right.text}}</small>
                <i class="fa fa-angle-left pull-right" ng-if="menu.children && !menu.right"></i>
            </span>
        </a>

        <app-menu-child children="menu.children" ng-if="menu.children"></app-menu-child>

    </li>
</ul>
`,
            replace: true,
            scope: {
                children: '='
            }
        };
    })
;
