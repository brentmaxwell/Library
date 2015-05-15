Date.prototype.monthAbbrev = [ "Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec" ];
Date.prototype.monthFull = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
Date.prototype.weekAbbrev = [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
Date.prototype.weekFull = [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

	
Date.prototype.format = function(format)
{
	var output = format;
	output = output.replace("uHH",this.getUTCHours().toString().padLeft("0",2));
	output = output.replace("HH",this.getHours().toString().padLeft("0",2));
	output = output.replace("umm",this.getUTCMinutes().toString().padLeft("0",2));
	output = output.replace("mm",this.getMinutes().toString().padLeft("0",2));
	output = output.replace("uss",this.getUTCSeconds().toString().padLeft("0",2));
	output = output.replace("ss",this.getSeconds().toString().padLeft("0",2));
	output = output.replace("uyyyy",this.getUTCFullYear().toString());
	output = output.replace("yyyy",this.getFullYear().toString());
	output = output.replace("uMM",(this.getUTCMonth()+1).toString().padLeft("0",2));
	output = output.replace("MM",(this.getMonth()+1).toString().padLeft("0",2));
	output = output.replace("uMMM",this.monthAbbrev[this.getUTCMonth()].toUpperCase());
	output = output.replace("MMM",this.monthAbbrev[this.getMonth()].toUpperCase());
	output = output.replace("udd",this.getUTCDate().toString().padLeft("0",2));
	output = output.replace("dd",this.getDate().toString().padLeft("0",2));
	output = output.replace("uK","Z");
	output = output.replace("K",this.getTimeZone());
	return output;
}

Date.prototype.getTimeZone = function()
{
	var output = "";
	var minutes = this.getTimezoneOffset();
	var hours = parseInt(minutes/60);
	minutes = minutes - (hours*60);
	if(hours > 0)
		output = "+";
	output = output + hours.toString().padLeft("0",2) + ":" + minutes.toString().padLeft("0",2);
	return output;
}