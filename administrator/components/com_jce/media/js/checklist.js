/* JCE Editor - 2.3.3.2 | 13 July 2013 | http://www.joomlacontenteditor.net | Copyright (C) 2006 - 2013 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
(function($){$.fn.checkList=function(options){this.each(function(){return $.CheckList.init(this,options);});};$.CheckList={options:{valueAsClassName:false,onCheck:$.noop},init:function(el,options){var self=this;$.extend(this.options,options);var ul=document.createElement('ul');var elms=[];if(el.nodeName=='SELECT'){$.each($('option',el),function(){elms.push({name:$(this).html(),value:$(this).val(),selected:$(this).prop('selected'),disabled:$(this).prop('disabled')});});}else{$.each(el.value.split(','),function(){elms.push({name:this,value:this});});}
$(el).hide();$(ul).addClass('widget-checklist').insertBefore(el);if($(el).hasClass('buttonlist')){$(ul).wrap('<div class="defaultSkin buttonlist" />');}
$.each(elms,function(){self.createElement(el,ul,this);});if($(el).hasClass('sortable')){$(ul).addClass('sortable').sortable({axis:'y',tolerance:'intersect',update:function(event,ui){self.setValue(el,$(ui.item).parent());},placeholder:"ui-state-highlight"});}},createElement:function(el,ul,n){var self=this,d=document,li=d.createElement('li'),plugin,button,toolbar;$(li).attr({title:n.value}).addClass('ui-widget-content ui-corner-all').appendTo(ul);if($(el).hasClass('buttonlist')){var name=el.name,s=name.split(/[^\w]+/);if(s&&s.length>1){plugin=s[1];}}
if(plugin){toolbar=$('span.profileLayoutContainerToolbar ul','#profileLayoutTable');button=$('span[data-button="'+n.value+'"]',toolbar);}
$('<input type="checkbox" />').addClass('checkbox inline').prop('checked',n.selected).prop('disabled',n.disabled).click(function(){$(this).trigger('checklist:check',this.checked);}).appendTo(li).on('checklist:check',function(e,state){self.setValue(el,ul);if(button){$(button).toggle(state);}
self.options.onCheck.call(self,[this,n]);});$(li).append('<label class="checkbox inline widget-checklist-'+n.value+'" title="'+n.name+'">'+n.name+'</label>');if(button&&$(el).hasClass('buttonlist')){$('label',li).before($(button).clone());}},setValue:function(el,ul){var x=$.map($('input[type="checkbox"]:checked',$('li',ul)),function(n){return $(n).parents('li:first').attr('title');});if(el.nodeName=='SELECT'){var options=[];$('option',el).each(function(i){var n=$.inArray(this.value,x);if(n>=0){$(this).prop('selected',true);options[n]=this;}else{$(this).prop('selected',false);options.push(this);}});$(el).empty().append(options).change();}else{$(el).val(x.join(',')).change();}}};})(jQuery);