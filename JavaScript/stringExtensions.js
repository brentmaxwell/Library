String.prototype.padLeft = function (pad, len)
{

	if (typeof(len) == "undefined") { var len = 0; }
	if (typeof(pad) == "undefined") { var pad = ' '; }

	if (len + 1 >= this.length)
	{
    	str = Array(len + 1 - this.length).join(pad) + this;

	} // switch

    return str;
}