function selectLoader(url,callBack,params,method){

	if(typeof method==="undefined")
		method = "POST";
	if(typeof params==="undefined")
		params = {};
	params["_token"]=$('meta[name="csrf-token"]').attr('content');
	$.ajax({
		url  : url,
		type : method,
		data : params,
	    success: function(optionsHtml){
	        if(typeof callBack ==='function')
	            callBack(true,optionsHtml);
	    },
	    error: function (optionsHtml) {
	        if(typeof callBack ==='function')
	            callBack(false,optionsHtml);
	    }
	});
}


function getOptions(jsonData){

	var options = "";
	var keys = Object.keys(jsonData);
	for(var i=0;i<keys.length;i++){
		options = options+"<option value='"+keys[i]+"'>"+jsonData[keys[i]]+"</option>"
	}
	return options;
}

function bindOptions(selector,jsonData,indexValue,indexText){

	if(typeof indexValue ==="undefined")
		indexValue = "id";
	if(typeof indexText ==="undefined")
		indexText = "name";

	var options = "";
	for(var i=0;i<jsonData.length;i++){
		options = options+"<option value='"+jsonData[i][indexValue]+"'>"+jsonData[i][indexText]+"</option>"
	}
	$(selector).html(options);
}

function propertyJoiner(data,property){
	var temp=[];
	var keys;
	try {
		for(var i=0;i<data.length;i++){
			keys = Object.keys(data[i]);
			for(var j=0;j<keys.length;j++){
				if(keys[j]===property)
					temp.push(data[i][keys[j]]);
			}
		}
	}
	catch(err) {
	}
	return temp;
}

/**
* funcion for make queryString from json object
*
* @param json   obj  objeto json
* @param string   prefix  string prefix
*
* @author Benomas benomas@gmail.com
* @date   2017-05-27
* @return string with queryString
*/
function serialize (obj, prefix){
	var str = [], p;
	for(p in obj) {
	  if (obj.hasOwnProperty(p)) {
	    var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
	    str.push((v !== null && typeof v === "object") ?
	    serialize(v, k) :
	    encodeURIComponent(k) + "=" + encodeURIComponent(v));
	  }
	}
	return str.join("&");
}

function dd(data){
    console.log(data);
}

function jsonMix(jsonTest1,jsonTest2){
	var jsonMixTest = {};
	if(typeof jsonTest1 && jsonTest1)
		for(var key in jsonTest1) jsonMixTest[key] = jsonTest1[key];

	if(jsonTest2)
		for(var key in jsonTest2) jsonMixTest[key] = jsonTest2[key];

	return jsonMixTest;
}

$.prototype.bindOptions =function(jsonData){
	var indexValue         = (indexValue = this.autSelAttr("value-property"))?indexValue:"id";
	var indexText          = (indexText = this.autSelAttr("text-property"))?indexText:"name";
	var defaultOptionValue = this.autSelAttr("def-option-value");
	var defaultOptionText  = this.autSelAttr("def-option-text");
	var olds               = this.autSelAttr("olds");
	if(olds){
		olds = olds(this.prop("name"));
		if(!$.isArray(olds))
			olds=[olds];
	}
	var options            = "";
	var selected           = "";
	if(typeof jsonData !== "undefined")
	for(var i=0;i<jsonData.length;i++){
		selected ="";
		if(olds && olds.length > 0)
			for(var j=0;j<olds.length;j++){
				if(jsonData[i][indexValue]==olds[j]){
					selected ="selected";
					break;
				}
			}

		options = options+"<option value='"+jsonData[i][indexValue]+"' "+selected+" >"+jsonData[i][indexText]+"</option>";
	}

	if(defaultOptionValue && defaultOptionText){
		selected ="selected";
		if(olds && olds.length > 0)
			selected ="";
		options = "<option value='"+defaultOptionValue+"' "+selected+" >"+defaultOptionText+"</option>"+options;
	}
	this.html(options);
	if(typeof this.attr("multiple")!=="undefined")
		if(typeof jsonData !== "undefined")
			this.attr("size",jsonData.length);
		else
			this.attr("size",0);

	this.trigger("change");
}

$.prototype.dd = function(params){
	if(typeof params !==undefined)
		console.log(params);
	else
		console.log(this);
}

$.prototype.setInputsBy = function(property,repository){
	if(typeof property==="undefined" || !property || typeof repository==="undefined" || !repository)
		return false;

	try {
		var inputs = this.find("input");
		var propertyValue;
		if(typeof inputs==="undefined" || !inputs || inputs.length<1)
			return false;

        for(var i=0; i<inputs.length;i++){
            propertyValue =  $(inputs[i]).prop(property);
			if(typeof propertyValue!=="undefined" && propertyValue && typeof repository[propertyValue]!=="undefined"){
				switch($(inputs[i]).prop("type")){
					case "radio":
					case "checkbox":
			        	if(typeof $(inputs[i]).attr("set-empty")!=="undefined"){
                    		$(inputs[i]).prop("checked","false");
                    		break;
			        	}
						if($(inputs[i]).val() == repository[propertyValue])
                    		$(inputs[i]).prop("checked","true");
						break;
					default:
			        	if(typeof $(inputs[i]).attr("set-empty")!=="undefined"){
							$(inputs[i]).val("");
                    		break;
			        	}
						$(inputs[i]).val(repository[propertyValue]);
				}
			}
        }
	}
	catch(err) {
	}
}

$.prototype.setInputsByName = function(repository){
	this.setInputsBy("name",repository);
}

$.prototype.setInputsById = function(repository){
	this.setInputsBy("id",repository);
}

$.prototype.setInputsByClass = function(repository){
	this.setInputsBy("class",repository);
}

$.prototype.setTextAreasBy = function(property,repository){
	if(typeof property==="undefined" || !property || typeof repository==="undefined" || !repository)
		return false;

	try {
		var textAreas = this.find("textarea");
		var propertyValue;
		if(typeof textAreas==="undefined" || !textAreas || textAreas.length<1)
			return false;

        for(var i=0; i<textAreas.length;i++){
        	if(typeof $(textAreas[i]).attr("set-empty")!=="undefined"){
				$(textAreas[i]).text("");
        	}
        	else{
	            propertyValue =  $(textAreas[i]).prop(property);
				if(typeof propertyValue!=="undefined" && propertyValue && typeof repository[propertyValue]!=="undefined")
					$(textAreas[i]).text(repository[propertyValue]);
        	}
        }
	}
	catch(err) {
	}
}

$.prototype.setTextAreasByName = function(repository){
	this.setTextAreasBy("name",repository);
}

$.prototype.setTextAreasById = function(repository){
	this.setTextAreasBy("id",repository);
}

$.prototype.setTextAreasByClass = function(repository){
	this.setTextAreasBy("class",repository);
}

$.prototype.attrLoader =  function(attr){
	var attrValue = this.attr(attr);
	return typeof attrValue!== undefined && attrValue?attrValue:null;
}

$.prototype.autSelAttr =  function(attr){
	attrValue = this.attrLoader("aut-sel-"+attr);
	if(attrValue && (attr==="olds" || attr==="data" || attr==="before-load"|| attr==="after-load"))
		attrValue=eval(attrValue);
	return attrValue;
}

$.prototype.currentAutSel = function(parentData){
	var attrData = this.autSelAttr("data");
	if(attrData)
		attrData = attrData();
	var data = jsonMix(parentData,attrData);
	var afterCallBack  =  this.autSelAttr("after-load");
	var beforeCallBack =  this.autSelAttr("before-load");

	if((urlService = this.autSelAttr("service"))){
		if(beforeCallBack)
			beforeCallBack();
		$.ajax({
			url  : urlService,
			type : (method = this.autSelAttr("method"))?method:"GET",
			data : serialize(data),
		    success:jsonResponse=>{
		    	this.bindOptions(jsonResponse.data);
				if(afterCallBack)
					afterCallBack();
		    },
		    error: jsonResponse=>{
				if(afterCallBack)
					afterCallBack();
		    }
		});
	}
}

$.prototype.filterEvent = function(child){
	var data;
	this.on("change",()=>{
		data = {};
		data[$(this).attr("name")]=this.val();
		$(child).currentAutSel(data);
	});
}

$.prototype.autSel = function(){
	/*
		attributes
			aut-sel
				filter-by
				callback
				service
				method
				data
				value-property
				text-property
				olds
				def-option-value
				def-option-text
	*/
	var selects    = this.find("select[aut-sel]");
	var filterBy   = null;
	var method     = null;
	var urlService = null;
	var callBack   = null;
	if(selects){
		for(var i=0; i<selects.length;i++){
			$(selects[i]).unbind("change");
		}
	    for(var i=0; i<selects.length;i++){
	    	if((filterBy = $(selects[i]).autSelAttr("filter-by")))
	    		this.find(filterBy).filterEvent($(selects[i]));
	    	else
	    		$(selects[i]).currentAutSel();
		}
	}
}

var slideTime=300;