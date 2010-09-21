function ajaxObj(divID)
{
    this.divID = divID;
    this.div = document.getElementById(divID);
    this.ajaxObj = this.createajaxObj()
}

ajaxObj.prototype.createajaxObj = function()
{
    var httprequest = false;
    if (window.XMLHttpRequest)
    {	// if Mozilla, Safari etc
        httprequest = new XMLHttpRequest();
        if (httprequest.overrideMimeType);
        httprequest.overrideMimeType('text/xml');
    }
    else if (window.ActiveXObject)
    {	// if IE
        try
        {
            httprequest = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            try
            {
                httprequest = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e) { }
        }
    }
    return httprequest;
}

// getAjaxcontent(url) - Makes asynchronous GET request to url with the supplied parameters
ajaxObj.prototype.getAjaxContent = function(url)
{
    if (this.ajaxObj)
    {
        var instanceOfajaxObj = this
        this.ajaxObj.onreadystatechange = function() { instanceOfajaxObj.processContent() }
        this.ajaxObj.open('GET', url, true)
        this.ajaxObj.send(null)
    }
}

// processfunction is the function to call when the content is recieved
ajaxObj.prototype.processContent = function(processfunction)
{
    if (this.ajaxObj.readyState == 4)
    { //if request of file completed
        if (this.ajaxObj.status == 200)
        { //if request was successful
            var xmldata = this.ajaxObj.responseXML
            this.processData(xmldata);
        }
    }
}