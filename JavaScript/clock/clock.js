function ClockObj(format)
{
	var self = this;
	self.format = format;
	self.value = ko.observable(new Date().format(self.format));
	
	self.tick = function()
	{
		self.value(new Date().format(self.format));
		setTimeout(self.tick,1000);
	}
	
	self.tick();
}