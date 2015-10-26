angular
    .module('app.core')
    .directive('seoMeta', seo);
function seo($log) {

    function updateAttribute(selector, attributeName, attributeValue) {
        if(!document) {
            $log.error('seoMeta: document is not available!');
            return;
        }

        if (!selector) {
            $log.error('seoMeta: Either of "name", "httpEquiv", "property" or "charset" must be provided!');
            return;
        }

        var el = document.querySelector(selector);
        if (el && el.setAttribute) {
            el.setAttribute(attributeName, attributeValue);
        }
    }

    function updateContent(selector, value) {
        if(!document) {
            $log.error('seoMeta: document is not available!');
            return;
        }

        if (!selector) {
            $log.error('seoMeta: Either of "name", "httpEquiv", "property" or "charset" must be provided!');
            return;
        }

        var el = document.querySelector(selector);
        if (el) {
            document.title = value;
        }
    }


    return {
        restrict: 'E',
        scope: {
            charset: '@',
            name: '@',
            content: '@',
            httpEquiv: '@',
            scheme: '@',
            property: '@',
            title: '@'
        },
        link: function(scope, iElem, iAttrs) {
            var selector;

            if(scope.title) {
                //$('title').html('my new meta title');
                selector = 'title';
            }

            if(scope.name) {
                selector = 'meta[name="' + scope.name + '"]';
            }

            if(scope.httpEquiv) {
                selector = 'meta[http-equiv="' + scope.httpEquiv + '"]';
            }

            if(scope.property) {
                selector = 'meta[property="' + scope.property + '"]';
            }

            // watch the content parameter and set the changing value as needed
            scope.$watch('title', function (newValue, oldValue) {
                if (typeof newValue !== 'undefined') {
                    updateContent(selector, scope.title);
                }
            });

            // watch the content parameter and set the changing value as needed
            scope.$watch('content', function (newValue, oldValue) {
                if (typeof newValue !== 'undefined') {
                    updateAttribute(selector, 'content', scope.content);
                }
            });

            // watch the charset parameter and set it as needed
            scope.$watch('charset', function (newValue, oldValue) {
                if (typeof newValue !== 'undefined') {
                    updateAttribute('meta[charset]', 'charset', scope.charset);
                }
            });
        }
    };
}