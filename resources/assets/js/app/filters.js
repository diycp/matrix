'use strict';

angular.module('app.filters', [])

    // url格式化,方便以后开启html5模式
    .filter('url', function () {
        return input => /^https?:/.test(input) ? input : `#/${input.replace(/^\//, '')}`;
    })

    // url格式化,方便以后开启html5模式
    .filter('markdown', function () {
        return (input, options) => marked(input.replace("\t", '  ').replace("\r", ''), options || null);
    })

    // 左侧菜单分组
    .filter('menuGroup', function () {
        return function (input) {
            if (!angular.isArray(input)) return [];

            let [max, groups, group, result] = [1, {}, {}, []];

            // input = Array.from(new Set(input)); //数组去重

            //分组
            angular.forEach(input, function (item) {
                let level = item['group'].split('|').length || 1;
                if (!groups[level]) {
                    groups[level] = [];
                    max = Math.max(max, level);
                }
                groups[level].push(Object.assign({}, item));
            });

            //合并
            for (let i = max; i > 1; i--) {
                let currents = groups[i];
                let parents = groups[i - 1];
                if (!parents) continue;

                // angular.forEach(parents, function (item) {
                //     item['children'] = null;
                // });

                angular.forEach(parents, function (parent) {
                    let key = parent['group'] + '|' + parent['name'];

                    angular.forEach(currents, function (current) {
                        if (key == current['group']) {
                            if (!parent['children']) parent['children'] = [];
                            parent['children'].push(current);
                        }
                    });
                });
            }
            groups = groups[1] || [];

            //拆分，按group名称分组
            angular.forEach(groups, function (item) {
                if (!group[item['group']]) group[item['group']] = [];
                group[item['group']].push(item);
            });

            // 数据合并
            let keys = Object.keys(group);
            angular.forEach(keys, function (item) {
                result.push({group: item});
                group[item].map(item2 => result.push(item2));
            });

            return result;
        };
    })

    // 左侧菜单筛选
    .filter('menuFilter', function () {
        return function (input, query) {
            if (!angular.isArray(input)) return [];

            let [parents, groups, max] = [[], {}, 1];

            //级别分组
            angular.forEach(input, function (item) {
                let length = item['group'].split('|').length;
                if (!groups[length]) {
                    groups[length] = [];
                    max = Math.max(max, length);
                }
                groups[length].push(Object.assign({}, item));
            });

            //保留上级操作
            for (let i = max; i > 1; i--) {
                let currents = groups[i];

                angular.forEach(currents, function (item) {
                    let key = item['group'] + '|' + item['name'];

                    if (parents.indexOf(key) != -1) {
                        parents.push(item['group']);
                        return true;
                    }

                    for (let key in item) {
                        if (typeof item[key] === 'string' && item[key].includes(query)) {
                            parents.push(item['group']);
                            return true;
                        }
                    }
                });
            }

            //筛选
            return input.filter(item => {
                let key = item['group'] + '|' + item['name'];
                if (parents.indexOf(key) != -1) return true;

                for (let key in item) {
                    if (typeof item[key] === 'string' && item[key].includes(query)) {
                        return true;
                    }
                }
            });
        };
    });
