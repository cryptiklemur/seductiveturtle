;
jQuery.fn.jqSelecta = function(opts){

	var thiz = this, //closure hook
		selectOption = jQuery(this), //the original form element
		ID_BASE = selectOption.attr('id'),
		CELL_REF = 'cell.ref', //pointer to <option> held in data() on respective rendered table cell
		OPT_REF  = 'opt.ref',  //pointer from <option> to cell (as above)
		defaults = {
			multiSelect: null, //valid values are; null|true|false  where null -> autodetect
			autoSelected: null, // null|true|false - null=leave as is, true=set all selected, false=set all unselected
			title: null,
			showHeader: true,
			showHeaderCloseIcon: true,
			showFooter: true,
			showMultiSelectFooterIcons: true,
			footerCancelButtonText: 'Cancel',
			footerOkButtonText: ' Ok ',
			showFooterOkCancelButtons: true,
			onOpen: function(){},
			onClose: function(){},
			//              onChange: function(){},
			labelCallback: function(i){
				if(options.multiSelect){
					return i + ' item' + ((i != 1) ? 's':'') + ' selected';
				}else{
					var s = selectOption.find('[selected=true]');
					if(s == null){
						s = jQuery(selectOption.children()[0]);
					}
					return s.html().replace(/\s+/g, ' ');
				}
			},
			height:null,
			width:'300px',
			buttonWidth:'174px',
			autoScrollOverflowY: true,
			autoScrollOverflowX: true,       //if false content exceeding <i>width</i> will have overflow hidden
			columns:2,
			//              displayEffect: 'slide', //valid values are slide|fade|show
//			minElementsForRender:1,  //will not render if select has less than <i>minElementsForRender</i> option elements
			fadeSpeed: 300,
			valueSetFrom: 'value',          //valid values are: 'value'|'title'|'text'|null
			titleSetFrom: 'title',          //valid values are: 'value'|'title'|'text'|null
			textSetFrom:  'text',           //valid values are: 'value'|'title'|'text'|null
			persistAsCookie: false,
			debug: false,
			trace: false,                           //adds coloured borders to various elements
			shadow: false
		},
		options = jQuery.extend(defaults, opts),
		iframe = null, currentState = null,
		selecta, table, tbody, holder, buttonDisplayIcon, buttonText;

		
	if(options.multiSelect === null){
		options.multiSelect = selectOption.attr('multiple');
		if(options.multiSelect === undefined){
			options.multiSelect === false;
		}
	}


	this.cancelAndClose = function(){
		if(options.multiSelect === true){
			thiz.revertState();
		}
		thiz.hideSelecta();
	};

	this.refreshLabel = function(){
		if(typeof buttonText !== 'undefined'){
			buttonText.html(options.labelCallback(selectOption.find('[selected=true]').size()));
		}
	};

	this.revertState = function(){
		//if(options.debug){debug("currentState.length: " + currentState.length);}
		if(currentState !== null && currentState.length > 0){
			this.selectNone();
			jQuery(currentState).attr('selected', true);
		}
		this.reloadState();
		this.refreshLabel();
	};

	this.reloadState = function(){
		selectOption.find('[selected=true]').each(function(i){
			selectElement(jQuery(this).data(OPT_REF));
		});

	};

	this.showSelecta = function(){
		holder.css('z-index', 1000);
		selecta.fadeIn(options.fadeSpeed);
		currentState = selectOption.find('[selected=true]');
		iframe = jQuery('<div style="border:0; overflow:hidden; position:absolute;top:0px'
				+ ((options.trace === true) ? ';border: solid blue 1px;':'')
				+ ';left:0px;width:'+selecta.width() + 'px;height:' + selecta.height()
				+ 'px;z-index:-1"></div>');
		jQuery('#'+ID_BASE+'_jqselecta-wrap').prepend(iframe);

		if(options.shadow === true){
			jQuery('#'+ID_BASE+'_jqselecta-shadow').fadeIn(options.fadeSpeed);
		}
		buttonDisplayIcon.removeClass('ui-icon-carat-1-s').addClass('ui-icon-carat-1-n');
		options.onOpen();
	};

	this.hideSelecta = function(){
		//if(options.debug){debug("hideSelecta() CALLED");}
		var fs = (options.multiSelect === true) ? options.fadeSpeed : (options.fadeSpeed*3);
		//if(options.debug){debug("fs: " + fs);}
		selecta.fadeOut(fs, function(){
			//if(options.debug){debug("removing iframe");}
			iframe.remove();
			//if(options.debug){debug("removed iframe");}
			buttonDisplayIcon.removeClass('ui-icon-carat-1-n').addClass('ui-icon-carat-1-s');
			//if(options.debug){debug("buttonDisplayIcon done, doing onClose...");}
			options.onClose();
			//if(options.debug){debug("onClose() done");}
		});
		//debug("selecta fadeout ed");
		if(options.shadow === true){
			//if(options.debug){debug("drop shadow");}
			jQuery('#'+ID_BASE+'_jqselecta-shadow').hide();
		}
		//if(options.debug){debug("holder css");}
		holder.css('z-index', 0);
		//debug("options.persistAsCookie: " + options.persistAsCookie);
		if(options.persistAsCookie === true){
			//if(options.debug){debug("dehydrateAsCookie()");}
			dehydrateAsCookie();
			//debug("done dehydrateAsCookie()");
		}
		//if(options.debug){debug("finished");}
	};

	/**
	 * Saving option.html & value as neither
	 * are necessarily unique (not surefire but
	 * better than using sequence/position or
	 * name/value alone)
	 * Note:
	 *  Cookie's data format is:
	 *              escape(value)+'='+escape(option.innerHTML)+'&'  ...
	 *  Cookie's name is: this.id + '_jqSelecta'
	 */    
	this.dehydrateAsCookie = function(){
		var v = '';
		selectOption.find('[selected=true]').each(function(i){
			if(i > 0){ v+= '&'; }
			v += escape(jQuery(this).attr('value'))+'='+escape(jQuery(this).html());
		});  
		if(v !== ''){
			jQuery.cookie(ID_BASE+'_jqSelecta', v);
		}
		//if(options.debug){debug("dehydrated: " + v);}
	};

	this.rehydrateFromCookie = function(){
		var str = jQuery.cookie(ID_BASE+'_jqSelecta'),
			c, i, v, selOpt;
		//if(options.debug){debug("rehydrating from: " + str);}
		if(str !== null){
			c = str.split(/\&/);
			if(c.length > 0){
				this.selectNone();
			}
			for(i = 0; i < c.length; i++){
				v = c[i].split(/\=/);
				selectOption.find('[value='+unescape(v[0])+']').each(function(i){
					selOpt = jQuery(this);
					//if(options.debug){debug("unescape(v[1]) === selOpt.html(): ",unescape(v[1])," === ",selOpt.html());}
					if(unescape(v[1]) === selOpt.html()){
						jQuery(this).attr('selected', true);
					}
				});
			}
			this.reloadState();
		}
	};


	this.toggleSelecta = function(){
		if(selecta.is(':visible')){ thiz.hideSelecta(); }
		else { thiz.showSelecta(); }
	};

	this.selectAll = function(){
		table.find('.cellectable').each(function(i){
			selectElement(this);
		});
		thiz.refreshLabel();
	};

	this.selectNone = function(){
		table.find('.cellectable').each(function(i){
			deselectElement(this);
		});
		thiz.refreshLabel();
	};

	this.selectInverse = function(){
		table.find('.cellectable').each(function(i){
			if(jQuery(this).data(CELL_REF).attr('selected') === true){
				deselectElement(this);
			}else{
				selectElement(this);
			}
		});
		thiz.refreshLabel();
	};


	this.getSelectedValues = function(){
		var retVal = [];
		jQuery(thiz).find('[selected=true]').each(function(i){
			retVal[retVal.length] = jQuery(this).attr('value');
		});
		return retVal;
	};

	function deselectElement(e){
		var c = jQuery(e);
		if(c.data(CELL_REF).attr('disabled')){return;}
		c.data(CELL_REF).removeAttr('selected');
		c.css('font-weight', 'normal');
		c.find('span').removeClass('ui-icon-check').addClass('ui-icon-close');
	}

	function selectElement(e){
		var c = jQuery(e);
		if(c.data(CELL_REF).attr('disabled')){return;}
		c.data(CELL_REF).attr('selected', true);
		c.css('font-weight', 'bold');
		c.find('span').removeClass('ui-icon-close').addClass('ui-icon-check');
	}

	function toggleElement(e){
		var c = jQuery(e);
		if(c.data(CELL_REF).attr('disabled')){return;}
		if(c.data(CELL_REF).attr('selected') === true && options.multiSelect){
			deselectElement(e);
			//if(options.debug){debug('toggling element {value:"'+jQuery(e).attr('value')+'"} now deselected');}
		}else{
			selectElement(e);
			//if(options.debug){debug('toggling element {value:"'+jQuery(e).attr('value')+'"} now selected');}
		}
		thiz.refreshLabel();
	}

	function debug(args){
		if(options.debug){
			var msg = '[jqSelecta]  ' + ((typeof(args) === 'Array') ?
					Array.prototype.join.call(args,'')  : args);
			if(window.console && window.console.log){
				window.console.log(msg);
			}else{
				alert(msg);
			}
		}
	}



	function instantiate(){
		selecta = jQuery('<div id="'+ID_BASE+'_jqselecta" class="ui-widget ui-helper-clearfix ui-widget-content ui-corner-all" style="display:none;width:'+options.width+'"></div>');
		table = jQuery('<table class="ui-helper-clearfix" style="text-align:left;border:0;padding:0;margin:0;width:'
				+options.width + ';z-index:19;height:'+options.height+'"></table>');
		tbody = jQuery('<tbody></tbody>').appendTo(table);
	
		var children = selectOption.children(),
			widthUnit = 'px',
			widthValue = options.width.replace(/[^\d]+/g, ''),
			columnWidth = (widthValue / options.columns),
			rowSize = Math.round(children.length / options.columns),
			row, j, i, index,
			child, cell, oText, text,
			oTitle, title, oValue, value, oSelected,
			headerCloseIcon, scrollableContainer,
			header, footer, hoverCraft,
			nobr, button,
			selectAllIcon, selectNoneIcon, selectInverseIcon,
			okButton, cancelButton,
			singluarSelected = null;

		if (options.multiSelect === false && selectOption.find('[selected=true]').size() > 0){
			singluarSelected = selectOption.find('[selected=true]')[0].index;
			if(singluarSelected === null){
				singluarSelected = 0;
			}
		}

		//if(options.debug){debug('columnWidth:'+columnWidth+ ', widthValue: '+widthValue+', options.columns: ' + options.columns + ', rowSize: ' + rowSize);}
		for(i = 0; i < rowSize; i++){
			row = jQuery('<tr></tr>');
			for(j = 0; j < options.columns; j++){
				//if(options.debug){debug("on table element[" + i + "][" + j + "] @ index: " + index);}
				index = i + j * rowSize;
				if(index >= children.length){
					for(; j < options.columns; j++){
						jQuery('<td> </td>').appendTo(row);
					}
					break;
				}
				child = jQuery(children[index]);
				text = oText = child.text();
				title = oTitle = child.attr('title'); 
				value = oValue = child.attr('value');


				if(options.textSetFrom === 'value'){
					text = oValue;
				}else if(options.textSetFrom === 'title'){
					text = oTitle;
				}
				if(options.valueSetFrom === 'text'){
					value = oText;
				}else if(options.valueSetFrom === 'title'){
					value = oTitle;
				}
				if(options.titleSetFrom === 'text'){
					title = oText;
				}else if(options.titleSetFrom === 'value'){
					title = oValue;
				}

				oSelected = child.attr('selected');
				if(!(options.multiSelect === false || options.autoSelected === null)){
					oSelected = options.autoSelected;
				}
				if(singluarSelected !== null && singluarSelected !== index){
					oSelected = false;
				}
				child.attr('selected', oSelected);
				
				
				cell = jQuery('<td title="' + title
					+ '" style="border:0px;cursor:pointer;'
					+ ((true === oSelected) ? 'font-weight:bold' : '')
					+ '" class="cellectable widget-content'
					+ '"><div style=white-space:nowrap;text-overflow:ellipsis;width:'
					+ columnWidth + widthUnit + ';overflow:hidden>'
					+ '<div style="float:left"><span class="ui-icon '
					+ ((true === oSelected) ? 'ui-icon-check' : 'ui-icon-close')
					+ '"/></div><div> ' + text
					+ '</div></div></td>');
	
				// Just (bi-directional) reference the original input option...
				// so original form methods work and all stays sync'd
				jQuery(cell).data(CELL_REF, child);
				jQuery(child).data(OPT_REF, cell);
				jQuery(cell).appendTo(row);   
				
				//ui-state-default ui-corner-top ui-state-disabled
				if(child.attr('disabled') === true){
					cell.addClass('ui-state-disabled');
				}else{
					cell.hover(
							function(){
								jQuery(this).addClass('ui-state-hover');
							},
							function(){
								jQuery(this).removeClass('ui-state-hover');
							}
		
					).click(function(){    
		
						var c = jQuery(this), o, v;
		
						if(options.multiSelect === false){
							//if(options.debug){debug("no multi-select");}
							o = c.data(CELL_REF);
							v = o.attr('selected');
							table.find('.cellectable').each(function(i){
								jQuery(this).css('font-weight', 'normal');
								jQuery(this).find('span').removeClass('ui-icon-check').addClass('ui-icon-close');
								jQuery(this).data(CELL_REF).removeAttr('selected');
							});
							o.attr('selected', v);
						}
						toggleElement(this);
						if(options.multiSelect === false){
							thiz.hideSelecta();
						}
						return false;
					});
				}
			}
			jQuery(row).appendTo(tbody);
		}
		jQuery(selecta).bind('mouseaway', function(){
			jQuery(this).find('ui-state-hover').removeClass('ui-state-hover');
		});
	
		if(true === options.showHeader){
			if(options.showHeaderCloseIcon === true){
				//if(options.debug){debug('doing close button');}
				headerCloseIcon = jQuery('<div title="Cancel &amp; Close" id="'+ID_BASE+'_jqselecta-header-close" class="ui-state-default ui-corner-all" style="float:right;cursor:pointer"><span class="ui-icon ui-icon-close"/></div>');
				headerCloseIcon.hover(
						function(){
							jQuery(this).addClass('ui-state-hover');
						},
						function(){
							jQuery(this).removeClass('ui-state-hover');
						}).click(thiz.cancelAndClose);
				header = jQuery('<div id="'+ID_BASE+'_jqselecta-header" class="ui-widget-header ui-helper-clearfix" style="padding:1px"></div>');
				header.append(headerCloseIcon);
			}
			if(options.title !== null){
				header.append('<div id="'+ID_BASE+'_jqselecta-header-text">'+options.title+'</div>');
			}
			header.appendTo(selecta);
		}
		scrollableContainer = jQuery('<div style="height:'+options.height+'!important;width:'+ options.width
				+ ';overflow-y:' + ((options.autoScrollOverflowY === true) ? 'scroll' : 'hidden')
				+ '!important;overflow-x:' + ((options.autoScrollOverflowX === true) ? 'auto' : 'hidden') + '!important"></div>');
		table.appendTo(scrollableContainer);
		scrollableContainer.appendTo(selecta);
	
		if(options.showFooter === true){
			footer = jQuery('<div id="'+ID_BASE+'_jqselecta-footer" class="ui-widget-header ui-helper-clearfix" style="padding:1px"></div>');
			hoverCraft = new Array();
			if(options.multiSelect === true && options.showMultiSelectFooterIcons === true){
				selectAllIcon = jQuery('<div title="Select All" id="'+ID_BASE+'_jqselecta-select-all" class="ui-state-default ui-corner-all" style="float:left;cursor:pointer"><span class="ui-icon ui-icon-circle-check"/></div>');
				selectNoneIcon = jQuery('<div title="Select None" id="'+ID_BASE+'_jqselecta-select-none" class="ui-state-default ui-corner-all" style="float:left;cursor:pointer"><span class="ui-icon ui-icon-circle-close"/></div>');
				selectInverseIcon = jQuery('<div title="Invert Selection" id="'+ID_BASE+'_jqselecta-select-inverse" class="ui-state-default ui-corner-all" style="float:left;cursor:pointer"><span class="ui-icon ui-icon-circle-triangle-s"/></div>');

				selectAllIcon.click(thiz.selectAll);
				selectNoneIcon.click(thiz.selectNone);
				selectInverseIcon.click(thiz.selectInverse);
				footer.append(selectAllIcon);
				footer.append(selectNoneIcon);
				footer.append(selectInverseIcon);
				hoverCraft.push(selectInverseIcon, selectAllIcon, selectNoneIcon);
			}
			if(options.showFooterOkCancelButtons === true){
				okButton = jQuery('<button class="ui-state-default ui-corner-all" style="text-overflow:ellipsis;overflow:hidden;float:right;cursor:pointer" type="button">'
						+ options.footerOkButtonText + '</button>');
				cancelButton = jQuery('<button class="ui-state-default ui-corner-all jqselecta_cancel" style="text-overflow:ellipsis;overflow:hidden;float:right;cursor:pointer" type="button">'
						+ options.footerCancelButtonText + '</button>');
				okButton.click(thiz.hideSelecta);
				cancelButton.click(thiz.cancelAndClose);
				okButton.appendTo(footer);
				cancelButton.appendTo(footer);
				hoverCraft.push(okButton, cancelButton);
			}
			footer.appendTo(selecta);
			jQuery(hoverCraft).each(
					function(){
						jQuery(this).hover(function(){
							jQuery(this).addClass('ui-state-hover');
						},function(){
							jQuery(this).removeClass('ui-state-hover');
						});
					});
	
		}
		//...Constructed
	
		if(options.persistAsCookie === true){
			rehydrateFromCookie();
		}
	
		// Replace current content (i.e. the select-options) with a button
		// TODO  and, if any label - hide, leave or use as button label
		//if(options.debug){debug("creating main button with width: " +selectOption.width());}
		button = jQuery('<button id="'+ID_BASE+'_jqselecta-button" class="ui-state-default ui-corner-all jqselecta_main_buttons" style="width:'
				+((options.buttonWidth===null)?(selectOption.width() + 'px'):options.buttonWidth)+';cursor:pointer" type="button"></button>');
		nobr = jQuery('<nobr></nobr>');
		buttonDisplayIcon = jQuery('<span class="ui-icon ui-icon-carat-1-s" style="float:right"/>');
		nobr.append(buttonDisplayIcon);
		buttonText = jQuery('<span style="width:'
				+((options.buttonWidth===null)?(selectOption.width() + 'px'):options.buttonWidth)+'text-overflow:ellipsis;overflow:hidden">'+ options.labelCallback(selectOption.find('[selected=true]').size()) + '</span>');
		nobr.append(buttonText);
		button.append(nobr);
		// Attach event handler to button    
		button.bind('click', thiz.toggleSelecta);
		button.hover(function(){ jQuery(this).addClass('ui-state-hover');},
				function(){ jQuery(this).removeClass('ui-state-hover');});
		// Position
		holder = jQuery('<span  id="'+ID_BASE+'_jqselecta-holder" style="margin:0;padding:0;overflow:visible;position:relative;width:'+options.width
				+ ((options.trace === true) ? ';border: dashed green 1px;':'')
				+ '"></span>');
		button.appendTo(holder);
	
		selecta.appendTo(holder);
	
		selectOption.after(holder);
		selectOption.hide();
		//if(options.debug){debug("****   HIDIN ****");}
		
		selecta.wrap('<div  id="'+ID_BASE+'_jqselecta-wrap" style="position:absolute;z-index:9000;display:block;width:'+ options.width
				+ ((options.trace === true) ? ';border: dotted red 1px':'')
				+ ';top:0px;left:0px'
				+ '"></div>');
	
		if(options.shadow === true){
			jQuery('#'+ID_BASE+'_jqselecta-wrap').prepend(jQuery('<div id="'+ID_BASE
					+ '_jqselecta-shadow" class="ui-widget-shadow" style="position:absolute;z-index:29;top:0;width:'
					+ selecta.width()+'px;top:'+ button.height() + 'px;left:0px;height: '+selecta.height()+'px;display:none"></div>'));
		}
	
		//if(options.debug){debug('...end of jqSelecta instantiation');}
		return thiz;
	}
	
	return instantiate();
//	end of jqSelecta
};