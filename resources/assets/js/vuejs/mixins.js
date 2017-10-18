export default {
    methods: {
        omitPathQuery() {
            var path = decodeURIComponent(this.$route.fullPath),
                pathParts = path.split('?'),
                pairs,
                args = [].slice.call(arguments);

            if (pathParts.length >= 2) {

                pairs = pathParts[1].split(/[&;]/g);

                args.forEach((arg) => {
                    for (var i = pairs.length; i-- > 0;) {
                        if (pairs[i].indexOf(arg + '=') == 0) pairs.splice(i, 1);
                    }
                });

                path = pathParts[0] + (pairs.length > 0 ? '?' + pairs.join('&') : '');
            }
            return decodeURIComponent(path);
        },
        changePage(event) {
            var self = this,
                $el = $(self.$el),
                $target = $(event.target),
                link;

            if (!$target.is('a')) return;

            event.preventDefault();

            function getUrlParts(url) {
                var a = document.createElement('a');
                a.href = url;

                return {
                    href: a.href,
                    host: a.host,
                    hostname: a.hostname,
                    port: a.port,
                    pathname: a.pathname,
                    protocol: a.protocol,
                    hash: a.hash,
                    search: a.search
                };
            }

            var parts = getUrlParts($target.attr('href')),
                path = decodeURIComponent((parts.pathname + parts.search).replace('ajax/', ''));

            if (path[0] !== '/') path = '/' + path;

            self.$router.push({
                path: path
            });
        }
    }
}