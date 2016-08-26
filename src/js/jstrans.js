var jstrans = function (path) {
    if (typeof path === 'undefined') {
        return null;
    }
    var selector = document.querySelector('input[name=\"jstrans-value-for-' + path + '\"]');
    if (selector) {
        return selector.value;
    } else {
        var json = %s;
        var keys = path.split('.');
        var value = json;
        
        for (var i in keys) {
            var key = keys[i];
            if (typeof value[key] === 'undefined') {
                return path;
            }
            value = value[key];
        }
        
        return value;
    }
};