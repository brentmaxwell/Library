function formatJson(json) {
    var jsonStr = JSON.stringify(json);
    var regeStr = '', // A EMPTY STRING TO EVENTUALLY HOLD THE FORMATTED STRINGIFIED OBJECT
        f = {
            brace: 0
        }; // AN OBJECT FOR TRACKING INCREMENTS/DECREMENTS,
    // IN PARTICULAR CURLY BRACES (OTHER PROPERTIES COULD BE ADDED)

    regeStr = jsonStr.replace(/({|}[,]*|[^{}:]+:[^{}:,]*[,{]*)/g, function (m, p1) {
        var rtnFn = function () {
            return '<div style="text-indent: ' + (f['brace'] * 20) + 'px;">' + p1 + '</div>';
        },
            rtnStr = 0;
        if (p1.lastIndexOf('{') === (p1.length - 1)) {
            rtnStr = rtnFn();
            f['brace'] += 1;
        } else if (p1.indexOf('}') === 0) {
            f['brace'] -= 1;
            rtnStr = rtnFn();
        } else {
            rtnStr = rtnFn();
        }
        return rtnStr;
    });
    return regeStr;
}