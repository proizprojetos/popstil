/* JCE Editor - 2.3.3.2 | 13 July 2013 | http://www.joomlacontenteditor.net | Copyright (C) 2006 - 2013 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
WFAggregator.add('vine',{params:{type:'simple',size:600},setup:function(){$('#vine_size').change(function(){$('#width, #height').val(this.value).change();});},getTitle:function(){return this.title||this.name;},getType:function(){return'iframe';},isSupported:function(v){if(typeof v=='object'){v=v.src||v.data||'';}
if(/vine\.co\/(.+)/.test(v)){return'vine';}
return false;},getValues:function(src){var self=this,data={},args={},type=this.getType(),id='';$.extend(args,$.String.query(src));$('input, select','#vine_options').each(function(){var k=$(this).attr('id'),v=$(this).val();k=k.substr(k.indexOf('_')+1);if($(this).is(':checkbox')){v=$(this).is(':checked')?1:0;}
args[k]=v;});var s=/vine\.co\/v\/([a-z0-9A-Z]+)\/?/.exec(src);if(s&&s.length>1){id=s[1];}
src='http://vine.co/v/'+id+'/embed/'+args.type||this.params.type;if(!/http(s)?:\/\//.test(src)){src='http://'+src;}
var query=$.param(args);if(query){src=src+(/\?/.test(src)?'&':'?')+query;}
data.src=src;$.extend(data,{'frameborder':0,'class':'vine-embed','width':args.size||this.params.size,'height':args.size||this.params.size});return data;},setValues:function(data){var self=this,src=data.src||data.data||'',id='';if(!src){return data;}
var s=/vine\.co\/v\/([a-z0-9A-Z]+)\/?(embed)?\/?(simple|postcard)?/.exec(src);if(s&&s.length>1){id=s[1];data.type=s.length==4?s[3]:'';}
data.src='http://vine.co/v/'+id+'/embed/';data.size=data.width||data.height||this.params.size;return data;},getAttributes:function(src){var args={},data=this.setValues({src:src})||{};$.each(data,function(k,v){if(k=='src'){return;}
args['vine_'+k]=v;});$.extend(args,{'src':data.src||src,'width':this.params.size,'height':this.params.size});return args;},setAttributes:function(){},onSelectFile:function(){},onInsert:function(){}});