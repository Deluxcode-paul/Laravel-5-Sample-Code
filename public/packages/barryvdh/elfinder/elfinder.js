// Documentation for client options:
// https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
$().ready(function () {
    $('#elfinder').elfinder({
        customData: {
            _token: csrf_token
        },
        url: backpack.elfinder.connectorUrl
    });
});