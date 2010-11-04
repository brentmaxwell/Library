jQuery.extend(
{
	getUrlParams: function()
	{
		var param_raw;
    	var params = [];

	    var param_raw = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    	for(var i = 0; i < param_raw.length; i++)
	    {
    		param = param_raw[i].split('=');
			params.push(param[0]);
			vars[param[0]] = param[1];
		}
		return params;
	},
	getUrlVar: function(name)
	{
		return jQuery.getUrlParams()[name];
	}
});