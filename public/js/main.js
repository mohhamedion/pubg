/*
 * bootstrap-table - v1.11.1 - 2017-02-22
 * https://github.com/wenzhixin/bootstrap-table
 * Copyright (c) 2017 zhixin wen
 * Licensed MIT License
 */
!function(a){"use strict";var b=null,c=function(a){var b=arguments,c=!0,d=1;return a=a.replace(/%s/g,function(){var a=b[d++];return"undefined"==typeof a?(c=!1,""):a}),c?a:""},d=function(b,c,d,e){var f="";return a.each(b,function(a,b){return b[c]===e?(f=b[d],!1):!0}),f},e=function(b,c){var d=-1;return a.each(b,function(a,b){return b.field===c?(d=a,!1):!0}),d},f=function(b){var c,d,e,f=0,g=[];for(c=0;c<b[0].length;c++)f+=b[0][c].colspan||1;for(c=0;c<b.length;c++)for(g[c]=[],d=0;f>d;d++)g[c][d]=!1;for(c=0;c<b.length;c++)for(d=0;d<b[c].length;d++){var h=b[c][d],i=h.rowspan||1,j=h.colspan||1,k=a.inArray(!1,g[c]);for(1===j&&(h.fieldIndex=k,"undefined"==typeof h.field&&(h.field=k)),e=0;i>e;e++)g[c+e][k]=!0;for(e=0;j>e;e++)g[c][k+e]=!0}},g=function(){if(null===b){var c,d,e=a("<p/>").addClass("fixed-table-scroll-inner"),f=a("<div/>").addClass("fixed-table-scroll-outer");f.append(e),a("body").append(f),c=e[0].offsetWidth,f.css("overflow","scroll"),d=e[0].offsetWidth,c===d&&(d=f[0].clientWidth),f.remove(),b=c-d}return b},h=function(b,d,e,f){var g=d;if("string"==typeof d){var h=d.split(".");h.length>1?(g=window,a.each(h,function(a,b){g=g[b]})):g=window[d]}return"object"==typeof g?g:"function"==typeof g?g.apply(b,e||[]):!g&&"string"==typeof d&&c.apply(this,[d].concat(e))?c.apply(this,[d].concat(e)):f},i=function(b,c,d){var e=Object.getOwnPropertyNames(b),f=Object.getOwnPropertyNames(c),g="";if(d&&e.length!==f.length)return!1;for(var h=0;h<e.length;h++)if(g=e[h],a.inArray(g,f)>-1&&b[g]!==c[g])return!1;return!0},j=function(a){return"string"==typeof a?a.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&#039;").replace(/`/g,"&#x60;"):a},k=function(a){for(var b in a){var c=b.split(/(?=[A-Z])/).join("-").toLowerCase();c!==b&&(a[c]=a[b],delete a[b])}return a},l=function(a,b,c){var d=a;if("string"!=typeof b||a.hasOwnProperty(b))return c?j(a[b]):a[b];var e=b.split(".");for(var f in e)e.hasOwnProperty(f)&&(d=d&&d[e[f]]);return c?j(d):d},m=function(){return!!(navigator.userAgent.indexOf("MSIE ")>0||navigator.userAgent.match(/Trident.*rv\:11\./))},n=function(){Object.keys||(Object.keys=function(){var a=Object.prototype.hasOwnProperty,b=!{toString:null}.propertyIsEnumerable("toString"),c=["toString","toLocaleString","valueOf","hasOwnProperty","isPrototypeOf","propertyIsEnumerable","constructor"],d=c.length;return function(e){if("object"!=typeof e&&("function"!=typeof e||null===e))throw new TypeError("Object.keys called on non-object");var f,g,h=[];for(f in e)a.call(e,f)&&h.push(f);if(b)for(g=0;d>g;g++)a.call(e,c[g])&&h.push(c[g]);return h}}())},o=function(b,c){this.options=c,this.$el=a(b),this.$el_=this.$el.clone(),this.timeoutId_=0,this.timeoutFooter_=0,this.init()};o.DEFAULTS={classes:"table table-hover",sortClass:void 0,locale:void 0,height:void 0,undefinedText:"-",sortName:void 0,sortOrder:"asc",sortStable:!1,striped:!1,columns:[[]],data:[],totalField:"total",dataField:"rows",method:"get",url:void 0,ajax:void 0,cache:!0,contentType:"application/json",dataType:"json",ajaxOptions:{},queryParams:function(a){return a},queryParamsType:"limit",responseHandler:function(a){return a},pagination:!1,onlyInfoPagination:!1,paginationLoop:!0,sidePagination:"client",totalRows:0,pageNumber:1,pageSize:10,pageList:[10,25,50,100],paginationHAlign:"right",paginationVAlign:"bottom",paginationDetailHAlign:"left",paginationPreText:"&lsaquo;",paginationNextText:"&rsaquo;",search:!1,searchOnEnterKey:!1,strictSearch:!1,searchAlign:"right",selectItemName:"btSelectItem",showHeader:!0,showFooter:!1,showColumns:!1,showPaginationSwitch:!1,showRefresh:!1,showToggle:!1,buttonsAlign:"right",smartDisplay:!0,escape:!1,minimumCountColumns:1,idField:void 0,uniqueId:void 0,cardView:!1,detailView:!1,detailFormatter:function(){return""},trimOnSearch:!0,clickToSelect:!1,singleSelect:!1,toolbar:void 0,toolbarAlign:"left",checkboxHeader:!0,sortable:!0,silentSort:!0,maintainSelected:!1,searchTimeOut:500,searchText:"",iconSize:void 0,buttonsClass:"default",iconsPrefix:"glyphicon",icons:{paginationSwitchDown:"glyphicon-collapse-down icon-chevron-down",paginationSwitchUp:"glyphicon-collapse-up icon-chevron-up",refresh:"glyphicon-refresh icon-refresh",toggle:"glyphicon-list-alt icon-list-alt",columns:"glyphicon-th icon-th",detailOpen:"glyphicon-plus icon-plus",detailClose:"glyphicon-minus icon-minus"},customSearch:a.noop,customSort:a.noop,rowStyle:function(){return{}},rowAttributes:function(){return{}},footerStyle:function(){return{}},onAll:function(){return!1},onClickCell:function(){return!1},onDblClickCell:function(){return!1},onClickRow:function(){return!1},onDblClickRow:function(){return!1},onSort:function(){return!1},onCheck:function(){return!1},onUncheck:function(){return!1},onCheckAll:function(){return!1},onUncheckAll:function(){return!1},onCheckSome:function(){return!1},onUncheckSome:function(){return!1},onLoadSuccess:function(){return!1},onLoadError:function(){return!1},onColumnSwitch:function(){return!1},onPageChange:function(){return!1},onSearch:function(){return!1},onToggle:function(){return!1},onPreBody:function(){return!1},onPostBody:function(){return!1},onPostHeader:function(){return!1},onExpandRow:function(){return!1},onCollapseRow:function(){return!1},onRefreshOptions:function(){return!1},onRefresh:function(){return!1},onResetView:function(){return!1}},o.LOCALES={},o.LOCALES["en-US"]=o.LOCALES.en={formatLoadingMessage:function(){return"Loading, please wait..."},formatRecordsPerPage:function(a){return c("%s rows per page",a)},formatShowingRows:function(a,b,d){return c("Showing %s to %s of %s rows",a,b,d)},formatDetailPagination:function(a){return c("Showing %s rows",a)},formatSearch:function(){return"Search"},formatNoMatches:function(){return"No matching records found"},formatPaginationSwitch:function(){return"Hide/Show pagination"},formatRefresh:function(){return"Refresh"},formatToggle:function(){return"Toggle"},formatColumns:function(){return"Columns"},formatAllRows:function(){return"All"}},a.extend(o.DEFAULTS,o.LOCALES["en-US"]),o.COLUMN_DEFAULTS={radio:!1,checkbox:!1,checkboxEnabled:!0,field:void 0,title:void 0,titleTooltip:void 0,"class":void 0,align:void 0,halign:void 0,falign:void 0,valign:void 0,width:void 0,sortable:!1,order:"asc",visible:!0,switchable:!0,clickToSelect:!0,formatter:void 0,footerFormatter:void 0,events:void 0,sorter:void 0,sortName:void 0,cellStyle:void 0,searchable:!0,searchFormatter:!0,cardVisible:!0,escape:!1},o.EVENTS={"all.bs.table":"onAll","click-cell.bs.table":"onClickCell","dbl-click-cell.bs.table":"onDblClickCell","click-row.bs.table":"onClickRow","dbl-click-row.bs.table":"onDblClickRow","sort.bs.table":"onSort","check.bs.table":"onCheck","uncheck.bs.table":"onUncheck","check-all.bs.table":"onCheckAll","uncheck-all.bs.table":"onUncheckAll","check-some.bs.table":"onCheckSome","uncheck-some.bs.table":"onUncheckSome","load-success.bs.table":"onLoadSuccess","load-error.bs.table":"onLoadError","column-switch.bs.table":"onColumnSwitch","page-change.bs.table":"onPageChange","search.bs.table":"onSearch","toggle.bs.table":"onToggle","pre-body.bs.table":"onPreBody","post-body.bs.table":"onPostBody","post-header.bs.table":"onPostHeader","expand-row.bs.table":"onExpandRow","collapse-row.bs.table":"onCollapseRow","refresh-options.bs.table":"onRefreshOptions","reset-view.bs.table":"onResetView","refresh.bs.table":"onRefresh"},o.prototype.init=function(){this.initLocale(),this.initContainer(),this.initTable(),this.initHeader(),this.initData(),this.initHiddenRows(),this.initFooter(),this.initToolbar(),this.initPagination(),this.initBody(),this.initSearchText(),this.initServer()},o.prototype.initLocale=function(){if(this.options.locale){var b=this.options.locale.split(/-|_/);b[0].toLowerCase(),b[1]&&b[1].toUpperCase(),a.fn.bootstrapTable.locales[this.options.locale]?a.extend(this.options,a.fn.bootstrapTable.locales[this.options.locale]):a.fn.bootstrapTable.locales[b.join("-")]?a.extend(this.options,a.fn.bootstrapTable.locales[b.join("-")]):a.fn.bootstrapTable.locales[b[0]]&&a.extend(this.options,a.fn.bootstrapTable.locales[b[0]])}},o.prototype.initContainer=function(){this.$container=a(['<div class="bootstrap-table">','<div class="fixed-table-toolbar"></div>',"top"===this.options.paginationVAlign||"both"===this.options.paginationVAlign?'<div class="fixed-table-pagination" style="clear: both;"></div>':"",'<div class="fixed-table-container">','<div class="fixed-table-header"><table></table></div>','<div class="fixed-table-body">','<div class="fixed-table-loading">',this.options.formatLoadingMessage(),"</div>","</div>",'<div class="fixed-table-footer"><table><tr></tr></table></div>',"bottom"===this.options.paginationVAlign||"both"===this.options.paginationVAlign?'<div class="fixed-table-pagination"></div>':"","</div>","</div>"].join("")),this.$container.insertAfter(this.$el),this.$tableContainer=this.$container.find(".fixed-table-container"),this.$tableHeader=this.$container.find(".fixed-table-header"),this.$tableBody=this.$container.find(".fixed-table-body"),this.$tableLoading=this.$container.find(".fixed-table-loading"),this.$tableFooter=this.$container.find(".fixed-table-footer"),this.$toolbar=this.$container.find(".fixed-table-toolbar"),this.$pagination=this.$container.find(".fixed-table-pagination"),this.$tableBody.append(this.$el),this.$container.after('<div class="clearfix"></div>'),this.$el.addClass(this.options.classes),this.options.striped&&this.$el.addClass("table-striped"),-1!==a.inArray("table-no-bordered",this.options.classes.split(" "))&&this.$tableContainer.addClass("table-no-bordered")},o.prototype.initTable=function(){var b=this,c=[],d=[];if(this.$header=this.$el.find(">thead"),this.$header.length||(this.$header=a("<thead></thead>").appendTo(this.$el)),this.$header.find("tr").each(function(){var b=[];a(this).find("th").each(function(){"undefined"!=typeof a(this).data("field")&&a(this).data("field",a(this).data("field")+""),b.push(a.extend({},{title:a(this).html(),"class":a(this).attr("class"),titleTooltip:a(this).attr("title"),rowspan:a(this).attr("rowspan")?+a(this).attr("rowspan"):void 0,colspan:a(this).attr("colspan")?+a(this).attr("colspan"):void 0},a(this).data()))}),c.push(b)}),a.isArray(this.options.columns[0])||(this.options.columns=[this.options.columns]),this.options.columns=a.extend(!0,[],c,this.options.columns),this.columns=[],f(this.options.columns),a.each(this.options.columns,function(c,d){a.each(d,function(d,e){e=a.extend({},o.COLUMN_DEFAULTS,e),"undefined"!=typeof e.fieldIndex&&(b.columns[e.fieldIndex]=e),b.options.columns[c][d]=e})}),!this.options.data.length){var e=[];this.$el.find(">tbody>tr").each(function(c){var f={};f._id=a(this).attr("id"),f._class=a(this).attr("class"),f._data=k(a(this).data()),a(this).find(">td").each(function(d){for(var g,h,i=a(this),j=+i.attr("colspan")||1,l=+i.attr("rowspan")||1;e[c]&&e[c][d];d++);for(g=d;d+j>g;g++)for(h=c;c+l>h;h++)e[h]||(e[h]=[]),e[h][g]=!0;var m=b.columns[d].field;f[m]=a(this).html(),f["_"+m+"_id"]=a(this).attr("id"),f["_"+m+"_class"]=a(this).attr("class"),f["_"+m+"_rowspan"]=a(this).attr("rowspan"),f["_"+m+"_colspan"]=a(this).attr("colspan"),f["_"+m+"_title"]=a(this).attr("title"),f["_"+m+"_data"]=k(a(this).data())}),d.push(f)}),this.options.data=d,d.length&&(this.fromHtml=!0)}},o.prototype.initHeader=function(){var b=this,d={},e=[];this.header={fields:[],styles:[],classes:[],formatters:[],events:[],sorters:[],sortNames:[],cellStyles:[],searchables:[]},a.each(this.options.columns,function(f,g){e.push("<tr>"),0===f&&!b.options.cardView&&b.options.detailView&&e.push(c('<th class="detail" rowspan="%s"><div class="fht-cell"></div></th>',b.options.columns.length)),a.each(g,function(a,f){var g="",h="",i="",k="",l=c(' class="%s"',f["class"]),m=(b.options.sortOrder||f.order,"px"),n=f.width;if(void 0===f.width||b.options.cardView||"string"==typeof f.width&&-1!==f.width.indexOf("%")&&(m="%"),f.width&&"string"==typeof f.width&&(n=f.width.replace("%","").replace("px","")),h=c("text-align: %s; ",f.halign?f.halign:f.align),i=c("text-align: %s; ",f.align),k=c("vertical-align: %s; ",f.valign),k+=c("width: %s; ",!f.checkbox&&!f.radio||n?n?n+m:void 0:"36px"),"undefined"!=typeof f.fieldIndex){if(b.header.fields[f.fieldIndex]=f.field,b.header.styles[f.fieldIndex]=i+k,b.header.classes[f.fieldIndex]=l,b.header.formatters[f.fieldIndex]=f.formatter,b.header.events[f.fieldIndex]=f.events,b.header.sorters[f.fieldIndex]=f.sorter,b.header.sortNames[f.fieldIndex]=f.sortName,b.header.cellStyles[f.fieldIndex]=f.cellStyle,b.header.searchables[f.fieldIndex]=f.searchable,!f.visible)return;if(b.options.cardView&&!f.cardVisible)return;d[f.field]=f}e.push("<th"+c(' title="%s"',f.titleTooltip),f.checkbox||f.radio?c(' class="bs-checkbox %s"',f["class"]||""):l,c(' style="%s"',h+k),c(' rowspan="%s"',f.rowspan),c(' colspan="%s"',f.colspan),c(' data-field="%s"',f.field),">"),e.push(c('<div class="th-inner %s">',b.options.sortable&&f.sortable?"sortable both":"")),g=b.options.escape?j(f.title):f.title,f.checkbox&&(!b.options.singleSelect&&b.options.checkboxHeader&&(g='<input name="btSelectAll" type="checkbox" />'),b.header.stateField=f.field),f.radio&&(g="",b.header.stateField=f.field,b.options.singleSelect=!0),e.push(g),e.push("</div>"),e.push('<div class="fht-cell"></div>'),e.push("</div>"),e.push("</th>")}),e.push("</tr>")}),this.$header.html(e.join("")),this.$header.find("th[data-field]").each(function(){a(this).data(d[a(this).data("field")])}),this.$container.off("click",".th-inner").on("click",".th-inner",function(c){var d=a(this);return b.options.detailView&&d.closest(".bootstrap-table")[0]!==b.$container[0]?!1:void(b.options.sortable&&d.parent().data().sortable&&b.onSort(c))}),this.$header.children().children().off("keypress").on("keypress",function(c){if(b.options.sortable&&a(this).data().sortable){var d=c.keyCode||c.which;13==d&&b.onSort(c)}}),a(window).off("resize.bootstrap-table"),!this.options.showHeader||this.options.cardView?(this.$header.hide(),this.$tableHeader.hide(),this.$tableLoading.css("top",0)):(this.$header.show(),this.$tableHeader.show(),this.$tableLoading.css("top",this.$header.outerHeight()+1),this.getCaret(),a(window).on("resize.bootstrap-table",a.proxy(this.resetWidth,this))),this.$selectAll=this.$header.find('[name="btSelectAll"]'),this.$selectAll.off("click").on("click",function(){var c=a(this).prop("checked");b[c?"checkAll":"uncheckAll"](),b.updateSelected()})},o.prototype.initFooter=function(){!this.options.showFooter||this.options.cardView?this.$tableFooter.hide():this.$tableFooter.show()},o.prototype.initData=function(a,b){this.data="append"===b?this.data.concat(a):"prepend"===b?[].concat(a).concat(this.data):a||this.options.data,this.options.data="append"===b?this.options.data.concat(a):"prepend"===b?[].concat(a).concat(this.options.data):this.data,"server"!==this.options.sidePagination&&this.initSort()},o.prototype.initSort=function(){var b=this,d=this.options.sortName,e="desc"===this.options.sortOrder?-1:1,f=a.inArray(this.options.sortName,this.header.fields),g=0;return this.options.customSort!==a.noop?void this.options.customSort.apply(this,[this.options.sortName,this.options.sortOrder]):void(-1!==f&&(this.options.sortStable&&a.each(this.data,function(a,b){b.hasOwnProperty("_position")||(b._position=a)}),this.data.sort(function(c,g){b.header.sortNames[f]&&(d=b.header.sortNames[f]);var i=l(c,d,b.options.escape),j=l(g,d,b.options.escape),k=h(b.header,b.header.sorters[f],[i,j]);return void 0!==k?e*k:((void 0===i||null===i)&&(i=""),(void 0===j||null===j)&&(j=""),b.options.sortStable&&i===j&&(i=c._position,j=g._position),a.isNumeric(i)&&a.isNumeric(j)?(i=parseFloat(i),j=parseFloat(j),j>i?-1*e:e):i===j?0:("string"!=typeof i&&(i=i.toString()),-1===i.localeCompare(j)?-1*e:e))}),void 0!==this.options.sortClass&&(clearTimeout(g),g=setTimeout(function(){b.$el.removeClass(b.options.sortClass);var a=b.$header.find(c('[data-field="%s"]',b.options.sortName).index()+1);b.$el.find(c("tr td:nth-child(%s)",a)).addClass(b.options.sortClass)},250))))},o.prototype.onSort=function(b){var c="keypress"===b.type?a(b.currentTarget):a(b.currentTarget).parent(),d=this.$header.find("th").eq(c.index());return this.$header.add(this.$header_).find("span.order").remove(),this.options.sortName===c.data("field")?this.options.sortOrder="asc"===this.options.sortOrder?"desc":"asc":(this.options.sortName=c.data("field"),this.options.sortOrder="asc"===c.data("order")?"desc":"asc"),this.trigger("sort",this.options.sortName,this.options.sortOrder),c.add(d).data("order",this.options.sortOrder),this.getCaret(),"server"===this.options.sidePagination?void this.initServer(this.options.silentSort):(this.initSort(),void this.initBody())},o.prototype.initToolbar=function(){var b,d,e=this,f=[],g=0,i=0;this.$toolbar.find(".bs-bars").children().length&&a("body").append(a(this.options.toolbar)),this.$toolbar.html(""),("string"==typeof this.options.toolbar||"object"==typeof this.options.toolbar)&&a(c('<div class="bs-bars pull-%s"></div>',this.options.toolbarAlign)).appendTo(this.$toolbar).append(a(this.options.toolbar)),f=[c('<div class="columns columns-%s btn-group pull-%s">',this.options.buttonsAlign,this.options.buttonsAlign)],"string"==typeof this.options.icons&&(this.options.icons=h(null,this.options.icons)),this.options.showPaginationSwitch&&f.push(c('<button class="btn'+c(" btn-%s",this.options.buttonsClass)+c(" btn-%s",this.options.iconSize)+'" type="button" name="paginationSwitch" aria-label="pagination Switch" title="%s">',this.options.formatPaginationSwitch()),c('<i class="%s %s"></i>',this.options.iconsPrefix,this.options.icons.paginationSwitchDown),"</button>"),this.options.showRefresh&&f.push(c('<button class="btn'+c(" btn-%s",this.options.buttonsClass)+c(" btn-%s",this.options.iconSize)+'" type="button" name="refresh" aria-label="refresh" title="%s">',this.options.formatRefresh()),c('<i class="%s %s"></i>',this.options.iconsPrefix,this.options.icons.refresh),"</button>"),this.options.showToggle&&f.push(c('<button class="btn'+c(" btn-%s",this.options.buttonsClass)+c(" btn-%s",this.options.iconSize)+'" type="button" name="toggle" aria-label="toggle" title="%s">',this.options.formatToggle()),c('<i class="%s %s"></i>',this.options.iconsPrefix,this.options.icons.toggle),"</button>"),this.options.showColumns&&(f.push(c('<div class="keep-open btn-group" title="%s">',this.options.formatColumns()),'<button type="button" aria-label="columns" class="btn'+c(" btn-%s",this.options.buttonsClass)+c(" btn-%s",this.options.iconSize)+' dropdown-toggle" data-toggle="dropdown">',c('<i class="%s %s"></i>',this.options.iconsPrefix,this.options.icons.columns),' <span class="caret"></span>',"</button>",'<ul class="dropdown-menu" role="menu">'),a.each(this.columns,function(a,b){if(!(b.radio||b.checkbox||e.options.cardView&&!b.cardVisible)){var d=b.visible?' checked="checked"':"";b.switchable&&(f.push(c('<li role="menuitem"><label><input type="checkbox" data-field="%s" value="%s"%s> %s</label></li>',b.field,a,d,b.title)),i++)}}),f.push("</ul>","</div>")),f.push("</div>"),(this.showToolbar||f.length>2)&&this.$toolbar.append(f.join("")),this.options.showPaginationSwitch&&this.$toolbar.find('button[name="paginationSwitch"]').off("click").on("click",a.proxy(this.togglePagination,this)),this.options.showRefresh&&this.$toolbar.find('button[name="refresh"]').off("click").on("click",a.proxy(this.refresh,this)),this.options.showToggle&&this.$toolbar.find('button[name="toggle"]').off("click").on("click",function(){e.toggleView()}),this.options.showColumns&&(b=this.$toolbar.find(".keep-open"),i<=this.options.minimumCountColumns&&b.find("input").prop("disabled",!0),b.find("li").off("click").on("click",function(a){a.stopImmediatePropagation()}),b.find("input").off("click").on("click",function(){var b=a(this);e.toggleColumn(a(this).val(),b.prop("checked"),!1),e.trigger("column-switch",a(this).data("field"),b.prop("checked"))})),this.options.search&&(f=[],f.push('<div class="pull-'+this.options.searchAlign+' search">',c('<input class="form-control'+c(" input-%s",this.options.iconSize)+'" type="text" placeholder="%s">',this.options.formatSearch()),"</div>"),this.$toolbar.append(f.join("")),d=this.$toolbar.find(".search input"),d.off("keyup drop blur").on("keyup drop blur",function(b){e.options.searchOnEnterKey&&13!==b.keyCode||a.inArray(b.keyCode,[37,38,39,40])>-1||(clearTimeout(g),g=setTimeout(function(){e.onSearch(b)},e.options.searchTimeOut))}),m()&&d.off("mouseup").on("mouseup",function(a){clearTimeout(g),g=setTimeout(function(){e.onSearch(a)},e.options.searchTimeOut)}))},o.prototype.onSearch=function(b){var c=a.trim(a(b.currentTarget).val());this.options.trimOnSearch&&a(b.currentTarget).val()!==c&&a(b.currentTarget).val(c),c!==this.searchText&&(this.searchText=c,this.options.searchText=c,this.options.pageNumber=1,this.initSearch(),this.updatePagination(),this.trigger("search",c))},o.prototype.initSearch=function(){var b=this;if("server"!==this.options.sidePagination){if(this.options.customSearch!==a.noop)return void this.options.customSearch.apply(this,[this.searchText]);var c=this.searchText&&(this.options.escape?j(this.searchText):this.searchText).toLowerCase(),d=a.isEmptyObject(this.filterColumns)?null:this.filterColumns;this.data=d?a.grep(this.options.data,function(b){for(var c in d)if(a.isArray(d[c])&&-1===a.inArray(b[c],d[c])||!a.isArray(d[c])&&b[c]!==d[c])return!1;return!0}):this.options.data,this.data=c?a.grep(this.data,function(d,f){for(var g=0;g<b.header.fields.length;g++)if(b.header.searchables[g]){var i,j=a.isNumeric(b.header.fields[g])?parseInt(b.header.fields[g],10):b.header.fields[g],k=b.columns[e(b.columns,j)];if("string"==typeof j){i=d;for(var l=j.split("."),m=0;m<l.length;m++)i=i[l[m]];k&&k.searchFormatter&&(i=h(k,b.header.formatters[g],[i,d,f],i))}else i=d[j];if("string"==typeof i||"number"==typeof i)if(b.options.strictSearch){if((i+"").toLowerCase()===c)return!0}else if(-1!==(i+"").toLowerCase().indexOf(c))return!0}return!1}):this.data}},o.prototype.initPagination=function(){if(!this.options.pagination)return void this.$pagination.hide();this.$pagination.show();var b,d,e,f,g,h,i,j,k,l=this,m=[],n=!1,o=this.getData(),p=this.options.pageList;if("server"!==this.options.sidePagination&&(this.options.totalRows=o.length),this.totalPages=0,this.options.totalRows){if(this.options.pageSize===this.options.formatAllRows())this.options.pageSize=this.options.totalRows,n=!0;else if(this.options.pageSize===this.options.totalRows){var q="string"==typeof this.options.pageList?this.options.pageList.replace("[","").replace("]","").replace(/ /g,"").toLowerCase().split(","):this.options.pageList;a.inArray(this.options.formatAllRows().toLowerCase(),q)>-1&&(n=!0)}this.totalPages=~~((this.options.totalRows-1)/this.options.pageSize)+1,this.options.totalPages=this.totalPages}if(this.totalPages>0&&this.options.pageNumber>this.totalPages&&(this.options.pageNumber=this.totalPages),this.pageFrom=(this.options.pageNumber-1)*this.options.pageSize+1,this.pageTo=this.options.pageNumber*this.options.pageSize,this.pageTo>this.options.totalRows&&(this.pageTo=this.options.totalRows),m.push('<div class="pull-'+this.options.paginationDetailHAlign+' pagination-detail">','<span class="pagination-info">',this.options.onlyInfoPagination?this.options.formatDetailPagination(this.options.totalRows):this.options.formatShowingRows(this.pageFrom,this.pageTo,this.options.totalRows),"</span>"),!this.options.onlyInfoPagination){m.push('<span class="page-list">');var r=[c('<span class="btn-group %s">',"top"===this.options.paginationVAlign||"both"===this.options.paginationVAlign?"dropdown":"dropup"),'<button type="button" class="btn'+c(" btn-%s",this.options.buttonsClass)+c(" btn-%s",this.options.iconSize)+' dropdown-toggle" data-toggle="dropdown">','<span class="page-size">',n?this.options.formatAllRows():this.options.pageSize,"</span>",' <span class="caret"></span>',"</button>",'<ul class="dropdown-menu" role="menu">'];if("string"==typeof this.options.pageList){var s=this.options.pageList.replace("[","").replace("]","").replace(/ /g,"").split(",");p=[],a.each(s,function(a,b){p.push(b.toUpperCase()===l.options.formatAllRows().toUpperCase()?l.options.formatAllRows():+b)})}for(a.each(p,function(a,b){if(!l.options.smartDisplay||0===a||p[a-1]<l.options.totalRows){var d;d=n?b===l.options.formatAllRows()?' class="active"':"":b===l.options.pageSize?' class="active"':"",r.push(c('<li role="menuitem"%s><a href="#">%s</a></li>',d,b))}}),r.push("</ul></span>"),m.push(this.options.formatRecordsPerPage(r.join(""))),m.push("</span>"),m.push("</div>",'<div class="pull-'+this.options.paginationHAlign+' pagination">','<ul class="pagination'+c(" pagination-%s",this.options.iconSize)+'">','<li class="page-pre"><a href="#">'+this.options.paginationPreText+"</a></li>"),this.totalPages<5?(d=1,e=this.totalPages):(d=this.options.pageNumber-2,e=d+4,1>d&&(d=1,e=5),e>this.totalPages&&(e=this.totalPages,d=e-4)),this.totalPages>=6&&(this.options.pageNumber>=3&&(m.push('<li class="page-first'+(1===this.options.pageNumber?" active":"")+'">','<a href="#">',1,"</a>","</li>"),d++),this.options.pageNumber>=4&&(4==this.options.pageNumber||6==this.totalPages||7==this.totalPages?d--:m.push('<li class="page-first-separator disabled">','<a href="#">...</a>',"</li>"),e--)),this.totalPages>=7&&this.options.pageNumber>=this.totalPages-2&&d--,6==this.totalPages?this.options.pageNumber>=this.totalPages-2&&e++:this.totalPages>=7&&(7==this.totalPages||this.options.pageNumber>=this.totalPages-3)&&e++,b=d;e>=b;b++)m.push('<li class="page-number'+(b===this.options.pageNumber?" active":"")+'">','<a href="#">',b,"</a>","</li>");this.totalPages>=8&&this.options.pageNumber<=this.totalPages-4&&m.push('<li class="page-last-separator disabled">','<a href="#">...</a>',"</li>"),this.totalPages>=6&&this.options.pageNumber<=this.totalPages-3&&m.push('<li class="page-last'+(this.totalPages===this.options.pageNumber?" active":"")+'">','<a href="#">',this.totalPages,"</a>","</li>"),m.push('<li class="page-next"><a href="#">'+this.options.paginationNextText+"</a></li>","</ul>","</div>")}this.$pagination.html(m.join("")),this.options.onlyInfoPagination||(f=this.$pagination.find(".page-list a"),g=this.$pagination.find(".page-first"),h=this.$pagination.find(".page-pre"),i=this.$pagination.find(".page-next"),j=this.$pagination.find(".page-last"),k=this.$pagination.find(".page-number"),this.options.smartDisplay&&(this.totalPages<=1&&this.$pagination.find("div.pagination").hide(),(p.length<2||this.options.totalRows<=p[0])&&this.$pagination.find("span.page-list").hide(),this.$pagination[this.getData().length?"show":"hide"]()),this.options.paginationLoop||(1===this.options.pageNumber&&h.addClass("disabled"),this.options.pageNumber===this.totalPages&&i.addClass("disabled")),n&&(this.options.pageSize=this.options.formatAllRows()),f.off("click").on("click",a.proxy(this.onPageListChange,this)),g.off("click").on("click",a.proxy(this.onPageFirst,this)),h.off("click").on("click",a.proxy(this.onPagePre,this)),i.off("click").on("click",a.proxy(this.onPageNext,this)),j.off("click").on("click",a.proxy(this.onPageLast,this)),k.off("click").on("click",a.proxy(this.onPageNumber,this)))},o.prototype.updatePagination=function(b){b&&a(b.currentTarget).hasClass("disabled")||(this.options.maintainSelected||this.resetRows(),this.initPagination(),"server"===this.options.sidePagination?this.initServer():this.initBody(),this.trigger("page-change",this.options.pageNumber,this.options.pageSize))},o.prototype.onPageListChange=function(b){var c=a(b.currentTarget);return c.parent().addClass("active").siblings().removeClass("active"),this.options.pageSize=c.text().toUpperCase()===this.options.formatAllRows().toUpperCase()?this.options.formatAllRows():+c.text(),this.$toolbar.find(".page-size").text(this.options.pageSize),this.updatePagination(b),!1},o.prototype.onPageFirst=function(a){return this.options.pageNumber=1,this.updatePagination(a),!1},o.prototype.onPagePre=function(a){return this.options.pageNumber-1===0?this.options.pageNumber=this.options.totalPages:this.options.pageNumber--,this.updatePagination(a),!1},o.prototype.onPageNext=function(a){return this.options.pageNumber+1>this.options.totalPages?this.options.pageNumber=1:this.options.pageNumber++,this.updatePagination(a),!1},o.prototype.onPageLast=function(a){return this.options.pageNumber=this.totalPages,this.updatePagination(a),!1},o.prototype.onPageNumber=function(b){return this.options.pageNumber!==+a(b.currentTarget).text()?(this.options.pageNumber=+a(b.currentTarget).text(),this.updatePagination(b),!1):void 0},o.prototype.initRow=function(b,e){var f,g=this,i=[],k={},m=[],n="",o={},p=[];if(!(a.inArray(b,this.hiddenRows)>-1)){if(k=h(this.options,this.options.rowStyle,[b,e],k),k&&k.css)for(f in k.css)m.push(f+": "+k.css[f]);if(o=h(this.options,this.options.rowAttributes,[b,e],o))for(f in o)p.push(c('%s="%s"',f,j(o[f])));return b._data&&!a.isEmptyObject(b._data)&&a.each(b._data,function(a,b){"index"!==a&&(n+=c(' data-%s="%s"',a,b))}),i.push("<tr",c(" %s",p.join(" ")),c(' id="%s"',a.isArray(b)?void 0:b._id),c(' class="%s"',k.classes||(a.isArray(b)?void 0:b._class)),c(' data-index="%s"',e),c(' data-uniqueid="%s"',b[this.options.uniqueId]),c("%s",n),">"),this.options.cardView&&i.push(c('<td colspan="%s"><div class="card-views">',this.header.fields.length)),!this.options.cardView&&this.options.detailView&&i.push("<td>",'<a class="detail-icon" href="#">',c('<i class="%s %s"></i>',this.options.iconsPrefix,this.options.icons.detailOpen),"</a>","</td>"),a.each(this.header.fields,function(f,n){var o="",p=l(b,n,g.options.escape),q="",r="",s={},t="",u=g.header.classes[f],v="",w="",x="",y="",z=g.columns[f];if(!(g.fromHtml&&"undefined"==typeof p||!z.visible||g.options.cardView&&!z.cardVisible)){if(z.escape&&(p=j(p)),k=c('style="%s"',m.concat(g.header.styles[f]).join("; ")),b["_"+n+"_id"]&&(t=c(' id="%s"',b["_"+n+"_id"])),b["_"+n+"_class"]&&(u=c(' class="%s"',b["_"+n+"_class"])),b["_"+n+"_rowspan"]&&(w=c(' rowspan="%s"',b["_"+n+"_rowspan"])),b["_"+n+"_colspan"]&&(x=c(' colspan="%s"',b["_"+n+"_colspan"])),b["_"+n+"_title"]&&(y=c(' title="%s"',b["_"+n+"_title"])),s=h(g.header,g.header.cellStyles[f],[p,b,e,n],s),s.classes&&(u=c(' class="%s"',s.classes)),s.css){var A=[];for(var B in s.css)A.push(B+": "+s.css[B]);k=c('style="%s"',A.concat(g.header.styles[f]).join("; "))}q=h(z,g.header.formatters[f],[p,b,e],p),b["_"+n+"_data"]&&!a.isEmptyObject(b["_"+n+"_data"])&&a.each(b["_"+n+"_data"],function(a,b){"index"!==a&&(v+=c(' data-%s="%s"',a,b))}),z.checkbox||z.radio?(r=z.checkbox?"checkbox":r,r=z.radio?"radio":r,o=[c(g.options.cardView?'<div class="card-view %s">':'<td class="bs-checkbox %s">',z["class"]||""),"<input"+c(' data-index="%s"',e)+c(' name="%s"',g.options.selectItemName)+c(' type="%s"',r)+c(' value="%s"',b[g.options.idField])+c(' checked="%s"',q===!0||p||q&&q.checked?"checked":void 0)+c(' disabled="%s"',!z.checkboxEnabled||q&&q.disabled?"disabled":void 0)+" />",g.header.formatters[f]&&"string"==typeof q?q:"",g.options.cardView?"</div>":"</td>"].join(""),b[g.header.stateField]=q===!0||q&&q.checked):(q="undefined"==typeof q||null===q?g.options.undefinedText:q,o=g.options.cardView?['<div class="card-view">',g.options.showHeader?c('<span class="title" %s>%s</span>',k,d(g.columns,"field","title",n)):"",c('<span class="value">%s</span>',q),"</div>"].join(""):[c("<td%s %s %s %s %s %s %s>",t,u,k,v,w,x,y),q,"</td>"].join(""),g.options.cardView&&g.options.smartDisplay&&""===q&&(o='<div class="card-view"></div>')),i.push(o)}}),this.options.cardView&&i.push("</div></td>"),i.push("</tr>"),i.join(" ")}},o.prototype.initBody=function(b){var d=this,f=this.getData();this.trigger("pre-body",f),this.$body=this.$el.find(">tbody"),this.$body.length||(this.$body=a("<tbody></tbody>").appendTo(this.$el)),this.options.pagination&&"server"!==this.options.sidePagination||(this.pageFrom=1,this.pageTo=f.length);for(var g,i=a(document.createDocumentFragment()),j=this.pageFrom-1;j<this.pageTo;j++){
    var k=f[j],m=this.initRow(k,j,f,i);g=g||!!m,m&&m!==!0&&i.append(m)}g||i.append('<tr class="no-records-found">'+c('<td colspan="%s">%s</td>',this.$header.find("th").length,this.options.formatNoMatches())+"</tr>"),this.$body.html(i),b||this.scrollTo(0),this.$body.find("> tr[data-index] > td").off("click dblclick").on("click dblclick",function(b){var f=a(this),g=f.parent(),h=d.data[g.data("index")],i=f[0].cellIndex,j=d.getVisibleFields(),k=j[d.options.detailView&&!d.options.cardView?i-1:i],m=d.columns[e(d.columns,k)],n=l(h,k,d.options.escape);if(!f.find(".detail-icon").length&&(d.trigger("click"===b.type?"click-cell":"dbl-click-cell",k,n,h,f),d.trigger("click"===b.type?"click-row":"dbl-click-row",h,g,k),"click"===b.type&&d.options.clickToSelect&&m.clickToSelect)){var o=g.find(c('[name="%s"]',d.options.selectItemName));o.length&&o[0].click()}}),this.$body.find("> tr[data-index] > td > .detail-icon").off("click").on("click",function(){var b=a(this),e=b.parent().parent(),g=e.data("index"),i=f[g];if(e.next().is("tr.detail-view"))b.find("i").attr("class",c("%s %s",d.options.iconsPrefix,d.options.icons.detailOpen)),d.trigger("collapse-row",g,i),e.next().remove();else{b.find("i").attr("class",c("%s %s",d.options.iconsPrefix,d.options.icons.detailClose)),e.after(c('<tr class="detail-view"><td colspan="%s"></td></tr>',e.find("td").length));var j=e.next().find("td"),k=h(d.options,d.options.detailFormatter,[g,i,j],"");1===j.length&&j.append(k),d.trigger("expand-row",g,i,j)}return d.resetView(),!1}),this.$selectItem=this.$body.find(c('[name="%s"]',this.options.selectItemName)),this.$selectItem.off("click").on("click",function(b){b.stopImmediatePropagation();var c=a(this),e=c.prop("checked"),f=d.data[c.data("index")];d.options.maintainSelected&&a(this).is(":radio")&&a.each(d.options.data,function(a,b){b[d.header.stateField]=!1}),f[d.header.stateField]=e,d.options.singleSelect&&(d.$selectItem.not(this).each(function(){d.data[a(this).data("index")][d.header.stateField]=!1}),d.$selectItem.filter(":checked").not(this).prop("checked",!1)),d.updateSelected(),d.trigger(e?"check":"uncheck",f,c)}),a.each(this.header.events,function(b,c){if(c){"string"==typeof c&&(c=h(null,c));var e=d.header.fields[b],f=a.inArray(e,d.getVisibleFields());d.options.detailView&&!d.options.cardView&&(f+=1);for(var g in c)d.$body.find(">tr:not(.no-records-found)").each(function(){var b=a(this),h=b.find(d.options.cardView?".card-view":"td").eq(f),i=g.indexOf(" "),j=g.substring(0,i),k=g.substring(i+1),l=c[g];h.find(k).off(j).on(j,function(a){var c=b.data("index"),f=d.data[c],g=f[e];l.apply(this,[a,g,f,c])})})}}),this.updateSelected(),this.resetView(),this.trigger("post-body",f)},o.prototype.initServer=function(b,c,d){var e,f=this,g={},i={searchText:this.searchText,sortName:this.options.sortName,sortOrder:this.options.sortOrder};this.options.pagination&&(i.pageSize=this.options.pageSize===this.options.formatAllRows()?this.options.totalRows:this.options.pageSize,i.pageNumber=this.options.pageNumber),(d||this.options.url||this.options.ajax)&&("limit"===this.options.queryParamsType&&(i={search:i.searchText,sort:i.sortName,order:i.sortOrder},this.options.pagination&&(i.offset=this.options.pageSize===this.options.formatAllRows()?0:this.options.pageSize*(this.options.pageNumber-1),i.limit=this.options.pageSize===this.options.formatAllRows()?this.options.totalRows:this.options.pageSize)),a.isEmptyObject(this.filterColumnsPartial)||(i.filter=JSON.stringify(this.filterColumnsPartial,null)),g=h(this.options,this.options.queryParams,[i],g),a.extend(g,c||{}),g!==!1&&(b||this.$tableLoading.show(),e=a.extend({},h(null,this.options.ajaxOptions),{type:this.options.method,url:d||this.options.url,data:"application/json"===this.options.contentType&&"post"===this.options.method?JSON.stringify(g):g,cache:this.options.cache,contentType:this.options.contentType,dataType:this.options.dataType,success:function(a){a=h(f.options,f.options.responseHandler,[a],a),f.load(a),f.trigger("load-success",a),b||f.$tableLoading.hide()},error:function(a){f.trigger("load-error",a.status,a),b||f.$tableLoading.hide()}}),this.options.ajax?h(this,this.options.ajax,[e],null):(this._xhr&&4!==this._xhr.readyState&&this._xhr.abort(),this._xhr=a.ajax(e))))},o.prototype.initSearchText=function(){if(this.options.search&&""!==this.options.searchText){var a=this.$toolbar.find(".search input");a.val(this.options.searchText),this.onSearch({currentTarget:a})}},o.prototype.getCaret=function(){var b=this;a.each(this.$header.find("th"),function(c,d){a(d).find(".sortable").removeClass("desc asc").addClass(a(d).data("field")===b.options.sortName?b.options.sortOrder:"both")})},o.prototype.updateSelected=function(){var b=this.$selectItem.filter(":enabled").length&&this.$selectItem.filter(":enabled").length===this.$selectItem.filter(":enabled").filter(":checked").length;this.$selectAll.add(this.$selectAll_).prop("checked",b),this.$selectItem.each(function(){a(this).closest("tr")[a(this).prop("checked")?"addClass":"removeClass"]("selected")})},o.prototype.updateRows=function(){var b=this;this.$selectItem.each(function(){b.data[a(this).data("index")][b.header.stateField]=a(this).prop("checked")})},o.prototype.resetRows=function(){var b=this;a.each(this.data,function(a,c){b.$selectAll.prop("checked",!1),b.$selectItem.prop("checked",!1),b.header.stateField&&(c[b.header.stateField]=!1)}),this.initHiddenRows()},o.prototype.trigger=function(b){var c=Array.prototype.slice.call(arguments,1);b+=".bs.table",this.options[o.EVENTS[b]].apply(this.options,c),this.$el.trigger(a.Event(b),c),this.options.onAll(b,c),this.$el.trigger(a.Event("all.bs.table"),[b,c])},o.prototype.resetHeader=function(){clearTimeout(this.timeoutId_),this.timeoutId_=setTimeout(a.proxy(this.fitHeader,this),this.$el.is(":hidden")?100:0)},o.prototype.fitHeader=function(){var b,d,e,f,h=this;if(h.$el.is(":hidden"))return void(h.timeoutId_=setTimeout(a.proxy(h.fitHeader,h),100));if(b=this.$tableBody.get(0),d=b.scrollWidth>b.clientWidth&&b.scrollHeight>b.clientHeight+this.$header.outerHeight()?g():0,this.$el.css("margin-top",-this.$header.outerHeight()),e=a(":focus"),e.length>0){var i=e.parents("th");if(i.length>0){var j=i.attr("data-field");if(void 0!==j){var k=this.$header.find("[data-field='"+j+"']");k.length>0&&k.find(":input").addClass("focus-temp")}}}this.$header_=this.$header.clone(!0,!0),this.$selectAll_=this.$header_.find('[name="btSelectAll"]'),this.$tableHeader.css({"margin-right":d}).find("table").css("width",this.$el.outerWidth()).html("").attr("class",this.$el.attr("class")).append(this.$header_),f=a(".focus-temp:visible:eq(0)"),f.length>0&&(f.focus(),this.$header.find(".focus-temp").removeClass("focus-temp")),this.$header.find("th[data-field]").each(function(){h.$header_.find(c('th[data-field="%s"]',a(this).data("field"))).data(a(this).data())});var l=this.getVisibleFields(),m=this.$header_.find("th");this.$body.find(">tr:first-child:not(.no-records-found) > *").each(function(b){var d=a(this),e=b;h.options.detailView&&!h.options.cardView&&(0===b&&h.$header_.find("th.detail").find(".fht-cell").width(d.innerWidth()),e=b-1);var f=h.$header_.find(c('th[data-field="%s"]',l[e]));f.length>1&&(f=a(m[d[0].cellIndex])),f.find(".fht-cell").width(d.innerWidth())}),this.$tableBody.off("scroll").on("scroll",function(){h.$tableHeader.scrollLeft(a(this).scrollLeft()),h.options.showFooter&&!h.options.cardView&&h.$tableFooter.scrollLeft(a(this).scrollLeft())}),h.trigger("post-header")},o.prototype.resetFooter=function(){var b=this,d=b.getData(),e=[];this.options.showFooter&&!this.options.cardView&&(!this.options.cardView&&this.options.detailView&&e.push('<td><div class="th-inner">&nbsp;</div><div class="fht-cell"></div></td>'),a.each(this.columns,function(a,f){var g,i="",j="",k=[],l={},m=c(' class="%s"',f["class"]);if(f.visible&&(!b.options.cardView||f.cardVisible)){if(i=c("text-align: %s; ",f.falign?f.falign:f.align),j=c("vertical-align: %s; ",f.valign),l=h(null,b.options.footerStyle),l&&l.css)for(g in l.css)k.push(g+": "+l.css[g]);e.push("<td",m,c(' style="%s"',i+j+k.concat().join("; ")),">"),e.push('<div class="th-inner">'),e.push(h(f,f.footerFormatter,[d],"&nbsp;")||"&nbsp;"),e.push("</div>"),e.push('<div class="fht-cell"></div>'),e.push("</div>"),e.push("</td>")}}),this.$tableFooter.find("tr").html(e.join("")),this.$tableFooter.show(),clearTimeout(this.timeoutFooter_),this.timeoutFooter_=setTimeout(a.proxy(this.fitFooter,this),this.$el.is(":hidden")?100:0))},o.prototype.fitFooter=function(){var b,c,d;return clearTimeout(this.timeoutFooter_),this.$el.is(":hidden")?void(this.timeoutFooter_=setTimeout(a.proxy(this.fitFooter,this),100)):(c=this.$el.css("width"),d=c>this.$tableBody.width()?g():0,this.$tableFooter.css({"margin-right":d}).find("table").css("width",c).attr("class",this.$el.attr("class")),b=this.$tableFooter.find("td"),void this.$body.find(">tr:first-child:not(.no-records-found) > *").each(function(c){var d=a(this);b.eq(c).find(".fht-cell").width(d.innerWidth())}))},o.prototype.toggleColumn=function(a,b,d){if(-1!==a&&(this.columns[a].visible=b,this.initHeader(),this.initSearch(),this.initPagination(),this.initBody(),this.options.showColumns)){var e=this.$toolbar.find(".keep-open input").prop("disabled",!1);d&&e.filter(c('[value="%s"]',a)).prop("checked",b),e.filter(":checked").length<=this.options.minimumCountColumns&&e.filter(":checked").prop("disabled",!0)}},o.prototype.getVisibleFields=function(){var b=this,c=[];return a.each(this.header.fields,function(a,d){var f=b.columns[e(b.columns,d)];f.visible&&c.push(d)}),c},o.prototype.resetView=function(a){var b=0;if(a&&a.height&&(this.options.height=a.height),this.$selectAll.prop("checked",this.$selectItem.length>0&&this.$selectItem.length===this.$selectItem.filter(":checked").length),this.options.height){var c=this.$toolbar.outerHeight(!0),d=this.$pagination.outerHeight(!0),e=this.options.height-c-d;this.$tableContainer.css("height",e+"px")}return this.options.cardView?(this.$el.css("margin-top","0"),this.$tableContainer.css("padding-bottom","0"),void this.$tableFooter.hide()):(this.options.showHeader&&this.options.height?(this.$tableHeader.show(),this.resetHeader(),b+=this.$header.outerHeight()):(this.$tableHeader.hide(),this.trigger("post-header")),this.options.showFooter&&(this.resetFooter(),this.options.height&&(b+=this.$tableFooter.outerHeight()+1)),this.getCaret(),this.$tableContainer.css("padding-bottom",b+"px"),void this.trigger("reset-view"))},o.prototype.getData=function(b){return!this.searchText&&a.isEmptyObject(this.filterColumns)&&a.isEmptyObject(this.filterColumnsPartial)?b?this.options.data.slice(this.pageFrom-1,this.pageTo):this.options.data:b?this.data.slice(this.pageFrom-1,this.pageTo):this.data},o.prototype.load=function(b){var c=!1;"server"===this.options.sidePagination?(this.options.totalRows=b[this.options.totalField],c=b.fixedScroll,b=b[this.options.dataField]):a.isArray(b)||(c=b.fixedScroll,b=b.data),this.initData(b),this.initSearch(),this.initPagination(),this.initBody(c)},o.prototype.append=function(a){this.initData(a,"append"),this.initSearch(),this.initPagination(),this.initSort(),this.initBody(!0)},o.prototype.prepend=function(a){this.initData(a,"prepend"),this.initSearch(),this.initPagination(),this.initSort(),this.initBody(!0)},o.prototype.remove=function(b){var c,d,e=this.options.data.length;if(b.hasOwnProperty("field")&&b.hasOwnProperty("values")){for(c=e-1;c>=0;c--)d=this.options.data[c],d.hasOwnProperty(b.field)&&-1!==a.inArray(d[b.field],b.values)&&(this.options.data.splice(c,1),"server"===this.options.sidePagination&&(this.options.totalRows-=1));e!==this.options.data.length&&(this.initSearch(),this.initPagination(),this.initSort(),this.initBody(!0))}},o.prototype.removeAll=function(){this.options.data.length>0&&(this.options.data.splice(0,this.options.data.length),this.initSearch(),this.initPagination(),this.initBody(!0))},o.prototype.getRowByUniqueId=function(a){var b,c,d,e=this.options.uniqueId,f=this.options.data.length,g=null;for(b=f-1;b>=0;b--){if(c=this.options.data[b],c.hasOwnProperty(e))d=c[e];else{if(!c._data.hasOwnProperty(e))continue;d=c._data[e]}if("string"==typeof d?a=a.toString():"number"==typeof d&&(Number(d)===d&&d%1===0?a=parseInt(a):d===Number(d)&&0!==d&&(a=parseFloat(a))),d===a){g=c;break}}return g},o.prototype.removeByUniqueId=function(a){var b=this.options.data.length,c=this.getRowByUniqueId(a);c&&this.options.data.splice(this.options.data.indexOf(c),1),b!==this.options.data.length&&(this.initSearch(),this.initPagination(),this.initBody(!0))},o.prototype.updateByUniqueId=function(b){var c=this,d=a.isArray(b)?b:[b];a.each(d,function(b,d){var e;d.hasOwnProperty("id")&&d.hasOwnProperty("row")&&(e=a.inArray(c.getRowByUniqueId(d.id),c.options.data),-1!==e&&a.extend(c.options.data[e],d.row))}),this.initSearch(),this.initPagination(),this.initSort(),this.initBody(!0)},o.prototype.insertRow=function(a){a.hasOwnProperty("index")&&a.hasOwnProperty("row")&&(this.data.splice(a.index,0,a.row),this.initSearch(),this.initPagination(),this.initSort(),this.initBody(!0))},o.prototype.updateRow=function(b){var c=this,d=a.isArray(b)?b:[b];a.each(d,function(b,d){d.hasOwnProperty("index")&&d.hasOwnProperty("row")&&a.extend(c.options.data[d.index],d.row)}),this.initSearch(),this.initPagination(),this.initSort(),this.initBody(!0)},o.prototype.initHiddenRows=function(){this.hiddenRows=[]},o.prototype.showRow=function(a){this.toggleRow(a,!0)},o.prototype.hideRow=function(a){this.toggleRow(a,!1)},o.prototype.toggleRow=function(b,c){var d,e;b.hasOwnProperty("index")?d=this.getData()[b.index]:b.hasOwnProperty("uniqueId")&&(d=this.getRowByUniqueId(b.uniqueId)),d&&(e=a.inArray(d,this.hiddenRows),c||-1!==e?c&&e>-1&&this.hiddenRows.splice(e,1):this.hiddenRows.push(d),this.initBody(!0))},o.prototype.getHiddenRows=function(){var b=this,c=this.getData(),d=[];return a.each(c,function(c,e){a.inArray(e,b.hiddenRows)>-1&&d.push(e)}),this.hiddenRows=d,d},o.prototype.mergeCells=function(b){var c,d,e,f=b.index,g=a.inArray(b.field,this.getVisibleFields()),h=b.rowspan||1,i=b.colspan||1,j=this.$body.find(">tr");if(this.options.detailView&&!this.options.cardView&&(g+=1),e=j.eq(f).find(">td").eq(g),!(0>f||0>g||f>=this.data.length)){for(c=f;f+h>c;c++)for(d=g;g+i>d;d++)j.eq(c).find(">td").eq(d).hide();e.attr("rowspan",h).attr("colspan",i).show()}},o.prototype.updateCell=function(a){a.hasOwnProperty("index")&&a.hasOwnProperty("field")&&a.hasOwnProperty("value")&&(this.data[a.index][a.field]=a.value,a.reinit!==!1&&(this.initSort(),this.initBody(!0)))},o.prototype.getOptions=function(){return this.options},o.prototype.getSelections=function(){var b=this;return a.grep(this.options.data,function(a){return a[b.header.stateField]===!0})},o.prototype.getAllSelections=function(){var b=this;return a.grep(this.options.data,function(a){return a[b.header.stateField]})},o.prototype.checkAll=function(){this.checkAll_(!0)},o.prototype.uncheckAll=function(){this.checkAll_(!1)},o.prototype.checkInvert=function(){var b=this,c=b.$selectItem.filter(":enabled"),d=c.filter(":checked");c.each(function(){a(this).prop("checked",!a(this).prop("checked"))}),b.updateRows(),b.updateSelected(),b.trigger("uncheck-some",d),d=b.getSelections(),b.trigger("check-some",d)},o.prototype.checkAll_=function(a){var b;a||(b=this.getSelections()),this.$selectAll.add(this.$selectAll_).prop("checked",a),this.$selectItem.filter(":enabled").prop("checked",a),this.updateRows(),a&&(b=this.getSelections()),this.trigger(a?"check-all":"uncheck-all",b)},o.prototype.check=function(a){this.check_(!0,a)},o.prototype.uncheck=function(a){this.check_(!1,a)},o.prototype.check_=function(a,b){var d=this.$selectItem.filter(c('[data-index="%s"]',b)).prop("checked",a);this.data[b][this.header.stateField]=a,this.updateSelected(),this.trigger(a?"check":"uncheck",this.data[b],d)},o.prototype.checkBy=function(a){this.checkBy_(!0,a)},o.prototype.uncheckBy=function(a){this.checkBy_(!1,a)},o.prototype.checkBy_=function(b,d){if(d.hasOwnProperty("field")&&d.hasOwnProperty("values")){var e=this,f=[];a.each(this.options.data,function(g,h){if(!h.hasOwnProperty(d.field))return!1;if(-1!==a.inArray(h[d.field],d.values)){var i=e.$selectItem.filter(":enabled").filter(c('[data-index="%s"]',g)).prop("checked",b);h[e.header.stateField]=b,f.push(h),e.trigger(b?"check":"uncheck",h,i)}}),this.updateSelected(),this.trigger(b?"check-some":"uncheck-some",f)}},o.prototype.destroy=function(){this.$el.insertBefore(this.$container),a(this.options.toolbar).insertBefore(this.$el),this.$container.next().remove(),this.$container.remove(),this.$el.html(this.$el_.html()).css("margin-top","0").attr("class",this.$el_.attr("class")||"")},o.prototype.showLoading=function(){this.$tableLoading.show()},o.prototype.hideLoading=function(){this.$tableLoading.hide()},o.prototype.togglePagination=function(){this.options.pagination=!this.options.pagination;var a=this.$toolbar.find('button[name="paginationSwitch"] i');this.options.pagination?a.attr("class",this.options.iconsPrefix+" "+this.options.icons.paginationSwitchDown):a.attr("class",this.options.iconsPrefix+" "+this.options.icons.paginationSwitchUp),this.updatePagination()},o.prototype.refresh=function(a){a&&a.url&&(this.options.url=a.url),a&&a.pageNumber&&(this.options.pageNumber=a.pageNumber),a&&a.pageSize&&(this.options.pageSize=a.pageSize),this.initServer(a&&a.silent,a&&a.query,a&&a.url),this.trigger("refresh",a)},o.prototype.resetWidth=function(){this.options.showHeader&&this.options.height&&this.fitHeader(),this.options.showFooter&&this.fitFooter()},o.prototype.showColumn=function(a){this.toggleColumn(e(this.columns,a),!0,!0)},o.prototype.hideColumn=function(a){this.toggleColumn(e(this.columns,a),!1,!0)},o.prototype.getHiddenColumns=function(){return a.grep(this.columns,function(a){return!a.visible})},o.prototype.getVisibleColumns=function(){return a.grep(this.columns,function(a){return a.visible})},o.prototype.toggleAllColumns=function(b){if(a.each(this.columns,function(a){this.columns[a].visible=b}),this.initHeader(),this.initSearch(),this.initPagination(),this.initBody(),this.options.showColumns){var c=this.$toolbar.find(".keep-open input").prop("disabled",!1);c.filter(":checked").length<=this.options.minimumCountColumns&&c.filter(":checked").prop("disabled",!0)}},o.prototype.showAllColumns=function(){this.toggleAllColumns(!0)},o.prototype.hideAllColumns=function(){this.toggleAllColumns(!1)},o.prototype.filterBy=function(b){this.filterColumns=a.isEmptyObject(b)?{}:b,this.options.pageNumber=1,this.initSearch(),this.updatePagination()},o.prototype.scrollTo=function(a){return"string"==typeof a&&(a="bottom"===a?this.$tableBody[0].scrollHeight:0),"number"==typeof a&&this.$tableBody.scrollTop(a),"undefined"==typeof a?this.$tableBody.scrollTop():void 0},o.prototype.getScrollPosition=function(){return this.scrollTo()},o.prototype.selectPage=function(a){a>0&&a<=this.options.totalPages&&(this.options.pageNumber=a,this.updatePagination())},o.prototype.prevPage=function(){this.options.pageNumber>1&&(this.options.pageNumber--,this.updatePagination())},o.prototype.nextPage=function(){this.options.pageNumber<this.options.totalPages&&(this.options.pageNumber++,this.updatePagination())},o.prototype.toggleView=function(){this.options.cardView=!this.options.cardView,this.initHeader(),this.initBody(),this.trigger("toggle",this.options.cardView)},o.prototype.refreshOptions=function(b){i(this.options,b,!0)||(this.options=a.extend(this.options,b),this.trigger("refresh-options",this.options),this.destroy(),this.init())},o.prototype.resetSearch=function(a){var b=this.$toolbar.find(".search input");b.val(a||""),this.onSearch({currentTarget:b})},o.prototype.expandRow_=function(a,b){var d=this.$body.find(c('> tr[data-index="%s"]',b));d.next().is("tr.detail-view")===(a?!1:!0)&&d.find("> td > .detail-icon").click()},o.prototype.expandRow=function(a){this.expandRow_(!0,a)},o.prototype.collapseRow=function(a){this.expandRow_(!1,a)},o.prototype.expandAllRows=function(b){if(b){var d=this.$body.find(c('> tr[data-index="%s"]',0)),e=this,f=null,g=!1,h=-1;if(d.next().is("tr.detail-view")?d.next().next().is("tr.detail-view")||(d.next().find(".detail-icon").click(),g=!0):(d.find("> td > .detail-icon").click(),g=!0),g)try{h=setInterval(function(){f=e.$body.find("tr.detail-view").last().find(".detail-icon"),f.length>0?f.click():clearInterval(h)},1)}catch(i){clearInterval(h)}}else for(var j=this.$body.children(),k=0;k<j.length;k++)this.expandRow_(!0,a(j[k]).data("index"))},o.prototype.collapseAllRows=function(b){if(b)this.expandRow_(!1,0);else for(var c=this.$body.children(),d=0;d<c.length;d++)this.expandRow_(!1,a(c[d]).data("index"))},o.prototype.updateFormatText=function(a,b){this.options[c("format%s",a)]&&("string"==typeof b?this.options[c("format%s",a)]=function(){return b}:"function"==typeof b&&(this.options[c("format%s",a)]=b)),this.initToolbar(),this.initPagination(),this.initBody()};var p=["getOptions","getSelections","getAllSelections","getData","load","append","prepend","remove","removeAll","insertRow","updateRow","updateCell","updateByUniqueId","removeByUniqueId","getRowByUniqueId","showRow","hideRow","getHiddenRows","mergeCells","checkAll","uncheckAll","checkInvert","check","uncheck","checkBy","uncheckBy","refresh","resetView","resetWidth","destroy","showLoading","hideLoading","showColumn","hideColumn","getHiddenColumns","getVisibleColumns","showAllColumns","hideAllColumns","filterBy","scrollTo","getScrollPosition","selectPage","prevPage","nextPage","togglePagination","toggleView","refreshOptions","resetSearch","expandRow","collapseRow","expandAllRows","collapseAllRows","updateFormatText"];a.fn.bootstrapTable=function(b){var c,d=Array.prototype.slice.call(arguments,1);return this.each(function(){var e=a(this),f=e.data("bootstrap.table"),g=a.extend({},o.DEFAULTS,e.data(),"object"==typeof b&&b);if("string"==typeof b){if(a.inArray(b,p)<0)throw new Error("Unknown method: "+b);if(!f)return;c=f[b].apply(f,d),"destroy"===b&&e.removeData("bootstrap.table")}f||e.data("bootstrap.table",f=new o(this,g))}),"undefined"==typeof c?this:c},a.fn.bootstrapTable.Constructor=o,a.fn.bootstrapTable.defaults=o.DEFAULTS,a.fn.bootstrapTable.columnDefaults=o.COLUMN_DEFAULTS,a.fn.bootstrapTable.locales=o.LOCALES,a.fn.bootstrapTable.methods=p,a.fn.bootstrapTable.utils={sprintf:c,getFieldIndex:e,compareObjects:i,calculateObjectValue:h,getItemField:l,objectKeys:n,isIEBrowser:m},a(function(){a('[data-toggle="table"]').bootstrapTable()})}(jQuery);
/*
 * bootstrap-table - v1.11.1 - 2017-02-22
 * https://github.com/wenzhixin/bootstrap-table
 * Copyright (c) 2017 zhixin wen
 * Licensed MIT License
 */
!function(a){"use strict";a.fn.bootstrapTable.locales["af-ZA"]={formatLoadingMessage:function(){return"Besig om te laai, wag asseblief ..."},formatRecordsPerPage:function(a){return a+" rekords per bladsy"},formatShowingRows:function(a,b,c){return"Resultate "+a+" tot "+b+" van "+c+" rye"},formatSearch:function(){return"Soek"},formatNoMatches:function(){return"Geen rekords gevind nie"},formatPaginationSwitch:function(){return"Wys/verberg bladsy nummering"},formatRefresh:function(){return"Herlaai"},formatToggle:function(){return"Wissel"},formatColumns:function(){return"Kolomme"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["af-ZA"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["ar-SA"]={formatLoadingMessage:function(){return"جاري التحميل, يرجى الإنتظار..."},formatRecordsPerPage:function(a){return a+" سجل لكل صفحة"},formatShowingRows:function(a,b,c){return"الظاهر "+a+" إلى "+b+" من "+c+" سجل"},formatSearch:function(){return"بحث"},formatNoMatches:function(){return"لا توجد نتائج مطابقة للبحث"},formatPaginationSwitch:function(){return"إخفاءإظهار ترقيم الصفحات"},formatRefresh:function(){return"تحديث"},formatToggle:function(){return"تغيير"},formatColumns:function(){return"أعمدة"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["ar-SA"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["ca-ES"]={formatLoadingMessage:function(){return"Espereu, si us plau..."},formatRecordsPerPage:function(a){return a+" resultats per pàgina"},formatShowingRows:function(a,b,c){return"Mostrant de "+a+" fins "+b+" - total "+c+" resultats"},formatSearch:function(){return"Cerca"},formatNoMatches:function(){return"No s'han trobat resultats"},formatPaginationSwitch:function(){return"Amaga/Mostra paginació"},formatRefresh:function(){return"Refresca"},formatToggle:function(){return"Alterna formatació"},formatColumns:function(){return"Columnes"},formatAllRows:function(){return"Tots"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["ca-ES"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["cs-CZ"]={formatLoadingMessage:function(){return"Čekejte, prosím..."},formatRecordsPerPage:function(a){return a+" položek na stránku"},formatShowingRows:function(a,b,c){return"Zobrazena "+a+". - "+b+". položka z celkových "+c},formatSearch:function(){return"Vyhledávání"},formatNoMatches:function(){return"Nenalezena žádná vyhovující položka"},formatPaginationSwitch:function(){return"Skrýt/Zobrazit stránkování"},formatRefresh:function(){return"Aktualizovat"},formatToggle:function(){return"Přepni"},formatColumns:function(){return"Sloupce"},formatAllRows:function(){return"Vše"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["cs-CZ"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["da-DK"]={formatLoadingMessage:function(){return"Indlæser, vent venligst..."},formatRecordsPerPage:function(a){return a+" poster pr side"},formatShowingRows:function(a,b,c){return"Viser "+a+" til "+b+" af "+c+" rækker"},formatSearch:function(){return"Søg"},formatNoMatches:function(){return"Ingen poster fundet"},formatRefresh:function(){return"Opdater"},formatToggle:function(){return"Skift"},formatColumns:function(){return"Kolonner"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["da-DK"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["de-DE"]={formatLoadingMessage:function(){return"Lade, bitte warten..."},formatRecordsPerPage:function(a){return a+" Einträge pro Seite."},formatShowingRows:function(a,b,c){return"Zeige Zeile "+a+" bis "+b+" von "+c+" Zeile"+(c>1?"n":"")+"."},formatDetailPagination:function(a){return"Zeige "+a+" Zeile"+(a>1?"n":"")+"."},formatSearch:function(){return"Suchen ..."},formatNoMatches:function(){return"Keine passenden Ergebnisse gefunden."},formatRefresh:function(){return"Neu laden"},formatToggle:function(){return"Umschalten"},formatColumns:function(){return"Spalten"},formatAllRows:function(){return"Alle"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["de-DE"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["el-GR"]={formatLoadingMessage:function(){return"Φορτώνει, παρακαλώ περιμένετε..."},formatRecordsPerPage:function(a){return a+" αποτελέσματα ανά σελίδα"},formatShowingRows:function(a,b,c){return"Εμφανίζονται από την "+a+" ως την "+b+" από σύνολο "+c+" σειρών"},formatSearch:function(){return"Αναζητήστε"},formatNoMatches:function(){return"Δεν βρέθηκαν αποτελέσματα"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["el-GR"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["en-US"]={formatLoadingMessage:function(){return"Loading, please wait..."},formatRecordsPerPage:function(a){return a+" rows per page"},formatShowingRows:function(a,b,c){return"Showing "+a+" to "+b+" of "+c+" rows"},formatSearch:function(){return"Search"},formatNoMatches:function(){return"No matching records found"},formatPaginationSwitch:function(){return"Hide/Show pagination"},formatRefresh:function(){return"Refresh"},formatToggle:function(){return"Toggle"},formatColumns:function(){return"Columns"},formatAllRows:function(){return"All"},formatExport:function(){return"Export data"},formatClearFilters:function(){return"Clear filters"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["en-US"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["es-AR"]={formatLoadingMessage:function(){return"Cargando, espere por favor..."},formatRecordsPerPage:function(a){return a+" registros por página"},formatShowingRows:function(a,b,c){return"Mostrando "+a+" a "+b+" de "+c+" filas"},formatSearch:function(){return"Buscar"},formatNoMatches:function(){return"No se encontraron registros"},formatAllRows:function(){return"Todo"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["es-AR"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["es-CL"]={formatLoadingMessage:function(){return"Cargando, espere por favor..."},formatRecordsPerPage:function(a){return a+" filas por página"},formatShowingRows:function(a,b,c){return"Mostrando "+a+" a "+b+" de "+c+" filas"},formatSearch:function(){return"Buscar"},formatNoMatches:function(){return"No se encontraron registros"},formatPaginationSwitch:function(){return"Ocultar/Mostrar paginación"},formatRefresh:function(){return"Refrescar"},formatToggle:function(){return"Cambiar"},formatColumns:function(){return"Columnas"},formatAllRows:function(){return"Todo"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["es-CL"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["es-CR"]={formatLoadingMessage:function(){return"Cargando, por favor espere..."},formatRecordsPerPage:function(a){return a+" registros por página"},formatShowingRows:function(a,b,c){return"Mostrando de "+a+" a "+b+" registros de "+c+" registros en total"},formatSearch:function(){return"Buscar"},formatNoMatches:function(){return"No se encontraron registros"},formatRefresh:function(){return"Refrescar"},formatToggle:function(){return"Alternar"},formatColumns:function(){return"Columnas"},formatAllRows:function(){return"Todo"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["es-CR"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["es-ES"]={formatLoadingMessage:function(){return"Por favor espere..."},formatRecordsPerPage:function(a){return a+" resultados por página"},formatShowingRows:function(a,b,c){return"Mostrando desde "+a+" hasta "+b+" - En total "+c+" resultados"},formatSearch:function(){return"Buscar"},formatNoMatches:function(){return"No se encontraron resultados"},formatPaginationSwitch:function(){return"Ocultar/Mostrar paginación"},formatRefresh:function(){return"Refrescar"},formatToggle:function(){return"Ocultar/Mostrar"},formatColumns:function(){return"Columnas"},formatAllRows:function(){return"Todos"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["es-ES"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["es-MX"]={formatLoadingMessage:function(){return"Cargando, espere por favor..."},formatRecordsPerPage:function(a){return a+" registros por página"},formatShowingRows:function(a,b,c){return"Mostrando "+a+" a "+b+" de "+c+" filas"},formatSearch:function(){return"Buscar"},formatNoMatches:function(){return"No se encontraron registros"},formatAllRows:function(){return"Todo"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["es-MX"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["es-NI"]={formatLoadingMessage:function(){return"Cargando, por favor espere..."},formatRecordsPerPage:function(a){return a+" registros por página"},formatShowingRows:function(a,b,c){return"Mostrando de "+a+" a "+b+" registros de "+c+" registros en total"},formatSearch:function(){return"Buscar"},formatNoMatches:function(){return"No se encontraron registros"},formatRefresh:function(){return"Refrescar"},formatToggle:function(){return"Alternar"},formatColumns:function(){return"Columnas"},formatAllRows:function(){return"Todo"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["es-NI"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["es-SP"]={formatLoadingMessage:function(){return"Cargando, por favor espera..."},formatRecordsPerPage:function(a){return a+" registros por p&#225;gina."},formatShowingRows:function(a,b,c){return a+" - "+b+" de "+c+" registros."},formatSearch:function(){return"Buscar"},formatNoMatches:function(){return"No se han encontrado registros."},formatRefresh:function(){return"Actualizar"},formatToggle:function(){return"Alternar"},formatColumns:function(){return"Columnas"},formatAllRows:function(){return"Todo"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["es-SP"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["et-EE"]={formatLoadingMessage:function(){return"Päring käib, palun oota..."},formatRecordsPerPage:function(a){return a+" rida lehe kohta"},formatShowingRows:function(a,b,c){return"Näitan tulemusi "+a+" kuni "+b+" - kokku "+c+" tulemust"},formatSearch:function(){return"Otsi"},formatNoMatches:function(){return"Päringu tingimustele ei vastanud ühtegi tulemust"},formatPaginationSwitch:function(){return"Näita/Peida lehtedeks jagamine"},formatRefresh:function(){return"Värskenda"},formatToggle:function(){return"Lülita"},formatColumns:function(){return"Veerud"},formatAllRows:function(){return"Kõik"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["et-EE"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["fa-IR"]={formatLoadingMessage:function(){return"در حال بارگذاری, لطفا صبر کنید..."},formatRecordsPerPage:function(a){return a+" رکورد در صفحه"},formatShowingRows:function(a,b,c){return"نمایش "+a+" تا "+b+" از "+c+" ردیف"},formatSearch:function(){return"جستجو"},formatNoMatches:function(){return"رکوردی یافت نشد."},formatPaginationSwitch:function(){return"نمایش/مخفی صفحه بندی"},formatRefresh:function(){return"به روز رسانی"},formatToggle:function(){return"تغییر نمایش"},formatColumns:function(){return"سطر ها"},formatAllRows:function(){return"همه"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["fa-IR"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["fr-BE"]={formatLoadingMessage:function(){return"Chargement en cours..."},formatRecordsPerPage:function(a){return a+" entrées par page"},formatShowingRows:function(a,b,c){return"Affiche de"+a+" à "+b+" sur "+c+" lignes"},formatSearch:function(){return"Recherche"},formatNoMatches:function(){return"Pas de fichiers trouvés"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["fr-BE"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["fr-FR"]={formatLoadingMessage:function(){return"Chargement en cours, patientez, s´il vous plaît ..."},formatRecordsPerPage:function(a){return a+" lignes par page"},formatShowingRows:function(a,b,c){return"Affichage des lignes "+a+" à "+b+" sur "+c+" lignes au total"},formatSearch:function(){return"Rechercher"},formatNoMatches:function(){return"Aucun résultat trouvé"},formatRefresh:function(){return"Rafraîchir"},formatToggle:function(){return"Alterner"},formatColumns:function(){return"Colonnes"},formatAllRows:function(){return"Tous"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["fr-FR"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["he-IL"]={formatLoadingMessage:function(){return"טוען, נא להמתין..."},formatRecordsPerPage:function(a){return a+" שורות בעמוד"},formatShowingRows:function(a,b,c){return"מציג "+a+" עד "+b+" מ-"+c+" שורות"},formatSearch:function(){return"חיפוש"},formatNoMatches:function(){return"לא נמצאו רשומות תואמות"},formatPaginationSwitch:function(){return"הסתר/הצג מספור דפים"},formatRefresh:function(){return"רענן"},formatToggle:function(){return"החלף תצוגה"},formatColumns:function(){return"עמודות"},formatAllRows:function(){return"הכל"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["he-IL"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["hr-HR"]={formatLoadingMessage:function(){return"Molimo pričekajte ..."},formatRecordsPerPage:function(a){return a+" broj zapisa po stranici"},formatShowingRows:function(a,b,c){return"Prikazujem "+a+". - "+b+". od ukupnog broja zapisa "+c},formatSearch:function(){return"Pretraži"},formatNoMatches:function(){return"Nije pronađen niti jedan zapis"},formatPaginationSwitch:function(){return"Prikaži/sakrij stranice"},formatRefresh:function(){return"Osvježi"},formatToggle:function(){return"Promijeni prikaz"},formatColumns:function(){return"Kolone"},formatAllRows:function(){return"Sve"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["hr-HR"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["hu-HU"]={formatLoadingMessage:function(){return"Betöltés, kérem várjon..."},formatRecordsPerPage:function(a){return a+" rekord per oldal"},formatShowingRows:function(a,b,c){return"Megjelenítve "+a+" - "+b+" / "+c+" összesen"},formatSearch:function(){return"Keresés"},formatNoMatches:function(){return"Nincs találat"},formatPaginationSwitch:function(){return"Lapozó elrejtése/megjelenítése"},formatRefresh:function(){return"Frissítés"},formatToggle:function(){return"Összecsuk/Kinyit"},formatColumns:function(){return"Oszlopok"},formatAllRows:function(){return"Összes"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["hu-HU"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["id-ID"]={formatLoadingMessage:function(){return"Memuat, mohon tunggu..."},formatRecordsPerPage:function(a){return a+" baris per halaman"},formatShowingRows:function(a,b,c){return"Menampilkan "+a+" sampai "+b+" dari "+c+" baris"},formatSearch:function(){return"Pencarian"},formatNoMatches:function(){return"Tidak ditemukan data yang cocok"},formatPaginationSwitch:function(){return"Sembunyikan/Tampilkan halaman"},formatRefresh:function(){return"Muat ulang"},formatToggle:function(){return"Beralih"},formatColumns:function(){return"kolom"},formatAllRows:function(){return"Semua"},formatExport:function(){return"Ekspor data"},formatClearFilters:function(){return"Bersihkan filter"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["id-ID"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["it-IT"]={formatLoadingMessage:function(){return"Caricamento in corso..."},formatRecordsPerPage:function(a){return a+" elementi per pagina"},formatShowingRows:function(a,b,c){return"Elementi mostrati da "+a+" a "+b+" (Numero totali di elementi "+c+")"},formatSearch:function(){return"Cerca"},formatNoMatches:function(){return"Nessun elemento trovato"},formatPaginationSwitch:function(){return"Nascondi/Mostra paginazione"},formatRefresh:function(){return"Aggiorna"},formatToggle:function(){return"Attiva/Disattiva"},formatColumns:function(){return"Colonne"},formatAllRows:function(){return"Tutto"},formatExport:function(){return"Esporta dati"},formatClearFilters:function(){return"Pulisci filtri"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["it-IT"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["ja-JP"]={formatLoadingMessage:function(){return"読み込み中です。少々お待ちください。"},formatRecordsPerPage:function(a){return"ページ当たり最大"+a+"件"},formatShowingRows:function(a,b,c){return"全"+c+"件から、"+a+"から"+b+"件目まで表示しています"},formatSearch:function(){return"検索"},formatNoMatches:function(){return"該当するレコードが見つかりません"},formatPaginationSwitch:function(){return"ページ数を表示・非表示"},formatRefresh:function(){return"更新"},formatToggle:function(){return"トグル"},formatColumns:function(){return"列"},formatAllRows:function(){return"すべて"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["ja-JP"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["ka-GE"]={formatLoadingMessage:function(){return"იტვირთება, გთხოვთ მოიცადოთ..."},formatRecordsPerPage:function(a){return a+" ჩანაწერი თითო გვერდზე"},formatShowingRows:function(a,b,c){return"ნაჩვენებია "+a+"-დან "+b+"-მდე ჩანაწერი ჯამური "+c+"-დან"},formatSearch:function(){return"ძებნა"},formatNoMatches:function(){return"მონაცემები არ არის"},formatPaginationSwitch:function(){return"გვერდების გადამრთველის დამალვა/გამოჩენა"},formatRefresh:function(){return"განახლება"},formatToggle:function(){return"ჩართვა/გამორთვა"},formatColumns:function(){return"სვეტები"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["ka-GE"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["ko-KR"]={formatLoadingMessage:function(){return"데이터를 불러오는 중입니다..."},formatRecordsPerPage:function(a){return"페이지 당 "+a+"개 데이터 출력"},formatShowingRows:function(a,b,c){return"전체 "+c+"개 중 "+a+"~"+b+"번째 데이터 출력,"},formatSearch:function(){return"검색"},formatNoMatches:function(){return"조회된 데이터가 없습니다."},formatRefresh:function(){return"새로 고침"},formatToggle:function(){return"전환"},formatColumns:function(){return"컬럼 필터링"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["ko-KR"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["ms-MY"]={formatLoadingMessage:function(){return"Permintaan sedang dimuatkan. Sila tunggu sebentar..."},formatRecordsPerPage:function(a){return a+" rekod setiap muka surat"},formatShowingRows:function(a,b,c){return"Sedang memaparkan rekod "+a+" hingga "+b+" daripada jumlah "+c+" rekod"},formatSearch:function(){return"Cari"},formatNoMatches:function(){return"Tiada rekod yang menyamai permintaan"},formatPaginationSwitch:function(){return"Tunjuk/sembunyi muka surat"},formatRefresh:function(){return"Muatsemula"},formatToggle:function(){return"Tukar"},formatColumns:function(){return"Lajur"},formatAllRows:function(){return"Semua"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["ms-MY"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["nb-NO"]={formatLoadingMessage:function(){return"Oppdaterer, vennligst vent..."},formatRecordsPerPage:function(a){return a+" poster pr side"},formatShowingRows:function(a,b,c){return"Viser "+a+" til "+b+" av "+c+" rekker"},formatSearch:function(){return"Søk"},formatNoMatches:function(){return"Ingen poster funnet"},formatRefresh:function(){return"Oppdater"},formatToggle:function(){return"Endre"},formatColumns:function(){return"Kolonner"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["nb-NO"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["nl-NL"]={formatLoadingMessage:function(){return"Laden, even geduld..."},formatRecordsPerPage:function(a){return a+" records per pagina"},formatShowingRows:function(a,b,c){return"Toon "+a+" tot "+b+" van "+c+" record"+(c>1?"s":"")},formatDetailPagination:function(a){return"Toon "+a+" record"+(a>1?"s":"")},formatSearch:function(){return"Zoeken"},formatNoMatches:function(){return"Geen resultaten gevonden"},formatRefresh:function(){return"Vernieuwen"},formatToggle:function(){return"Omschakelen"},formatColumns:function(){return"Kolommen"},formatAllRows:function(){return"Alle"},formatPaginationSwitch:function(){return"Verberg/Toon paginatie"},formatExport:function(){return"Exporteer data"},formatClearFilters:function(){return"Verwijder filters"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["nl-NL"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["pl-PL"]={formatLoadingMessage:function(){return"Ładowanie, proszę czekać..."},formatRecordsPerPage:function(a){return a+" rekordów na stronę"},formatShowingRows:function(a,b,c){return"Wyświetlanie rekordów od "+a+" do "+b+" z "+c},formatSearch:function(){return"Szukaj"},formatNoMatches:function(){return"Niestety, nic nie znaleziono"},formatRefresh:function(){return"Odśwież"},formatToggle:function(){return"Przełącz"},formatColumns:function(){return"Kolumny"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["pl-PL"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["pt-BR"]={formatLoadingMessage:function(){return"Carregando, aguarde..."},formatRecordsPerPage:function(a){return a+" registros por página"},formatShowingRows:function(a,b,c){return"Exibindo "+a+" até "+b+" de "+c+" linhas"},formatSearch:function(){return"Pesquisar"},formatRefresh:function(){return"Recarregar"},formatToggle:function(){return"Alternar"},formatColumns:function(){return"Colunas"},formatPaginationSwitch:function(){return"Ocultar/Exibir paginação"},formatNoMatches:function(){return"Nenhum registro encontrado"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["pt-BR"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["pt-PT"]={formatLoadingMessage:function(){return"A carregar, por favor aguarde..."},formatRecordsPerPage:function(a){return a+" registos por p&aacute;gina"},formatShowingRows:function(a,b,c){return"A mostrar "+a+" at&eacute; "+b+" de "+c+" linhas"},formatSearch:function(){return"Pesquisa"},formatNoMatches:function(){return"Nenhum registo encontrado"},formatPaginationSwitch:function(){return"Esconder/Mostrar pagina&ccedil&atilde;o"},formatRefresh:function(){return"Atualizar"},formatToggle:function(){return"Alternar"},formatColumns:function(){return"Colunas"},formatAllRows:function(){return"Tudo"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["pt-PT"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["ro-RO"]={formatLoadingMessage:function(){return"Se incarca, va rugam asteptati..."},formatRecordsPerPage:function(a){return a+" inregistrari pe pagina"},formatShowingRows:function(a,b,c){return"Arata de la "+a+" pana la "+b+" din "+c+" randuri"},formatSearch:function(){return"Cauta"},formatNoMatches:function(){return"Nu au fost gasite inregistrari"},formatPaginationSwitch:function(){return"Ascunde/Arata paginatia"},formatRefresh:function(){return"Reincarca"},formatToggle:function(){return"Comuta"},formatColumns:function(){return"Coloane"},formatAllRows:function(){return"Toate"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["ro-RO"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["ru-RU"]={formatLoadingMessage:function(){return"Пожалуйста, подождите, идёт загрузка..."},formatRecordsPerPage:function(a){return a+" записей на страницу"},formatShowingRows:function(a,b,c){return"Записи с "+a+" по "+b+" из "+c},formatSearch:function(){return"Поиск"},formatNoMatches:function(){return"Ничего не найдено"},formatRefresh:function(){return"Обновить"},formatToggle:function(){return"Переключить"},formatColumns:function(){return"Колонки"},formatClearFilters:function(){return"Очистить фильтры"},formatMultipleSort:function(){return"Множественная сортировка"},formatAddLevel:function(){return"Добавить уровень"},formatDeleteLevel:function(){return"Удалить уровень"},formatColumn:function(){return"Колонка"},formatOrder:function(){return"Порядок"},formatSortBy:function(){return"Сортировать по"},formatThenBy:function(){return"затем по"},formatSort:function(){return"Сортировать"},formatCancel:function(){return"Отмена"},formatDuplicateAlertTitle:function(){return"Дублирование колонок!"},formatDuplicateAlertDescription:function(){return"Удалите, пожалуйста, дублирующую колонку, или замените ее на другую."}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["ru-RU"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["sk-SK"]={formatLoadingMessage:function(){return"Prosím čakajte ..."},formatRecordsPerPage:function(a){return a+" záznamov na stranu"},formatShowingRows:function(a,b,c){return"Zobrazená "+a+". - "+b+". položka z celkových "+c},formatSearch:function(){return"Vyhľadávanie"},formatNoMatches:function(){return"Nenájdená žiadna vyhovujúca položka"},formatRefresh:function(){return"Obnoviť"},formatToggle:function(){return"Prepni"},formatColumns:function(){return"Stĺpce"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["sk-SK"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["sv-SE"]={formatLoadingMessage:function(){return"Laddar, vänligen vänta..."},formatRecordsPerPage:function(a){return a+" rader per sida"},formatShowingRows:function(a,b,c){return"Visa "+a+" till "+b+" av "+c+" rader"},formatSearch:function(){return"Sök"},formatNoMatches:function(){return"Inga matchande resultat funna."},formatRefresh:function(){return"Uppdatera"},formatToggle:function(){return"Skifta"},formatColumns:function(){return"kolumn"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["sv-SE"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["th-TH"]={formatLoadingMessage:function(){return"กำลังโหลดข้อมูล, กรุณารอสักครู่..."},formatRecordsPerPage:function(a){return a+" รายการต่อหน้า"},formatShowingRows:function(a,b,c){return"รายการที่ "+a+" ถึง "+b+" จากทั้งหมด "+c+" รายการ"},formatSearch:function(){return"ค้นหา"},formatNoMatches:function(){return"ไม่พบรายการที่ค้นหา !"},formatRefresh:function(){return"รีเฟรส"},formatToggle:function(){return"สลับมุมมอง"},formatColumns:function(){return"คอลัมน์"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["th-TH"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["tr-TR"]={formatLoadingMessage:function(){return"Yükleniyor, lütfen bekleyin..."},formatRecordsPerPage:function(a){return"Sayfa başına "+a+" kayıt."},formatShowingRows:function(a,b,c){return c+" kayıttan "+a+"-"+b+" arası gösteriliyor."},formatSearch:function(){return"Ara"},formatNoMatches:function(){return"Eşleşen kayıt bulunamadı."},formatRefresh:function(){return"Yenile"},formatToggle:function(){return"Değiştir"},formatColumns:function(){return"Sütunlar"},formatAllRows:function(){return"Tüm Satırlar"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["tr-TR"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["uk-UA"]={formatLoadingMessage:function(){return"Завантаження, будь ласка, зачекайте..."},formatRecordsPerPage:function(a){return a+" записів на сторінку"},formatShowingRows:function(a,b,c){return"Показано з "+a+" по "+b+". Всього: "+c},formatSearch:function(){return"Пошук"},formatNoMatches:function(){return"Не знайдено жодного запису"},formatRefresh:function(){return"Оновити"},formatToggle:function(){return"Змінити"},formatColumns:function(){return"Стовпці"},formatClearFilters:function(){return"Очистити фільтри"},formatMultipleSort:function(){return"Сортування за кількома стовпцями"},formatAddLevel:function(){return"Додати рівень"},formatDeleteLevel:function(){return"Видалити рівень"},formatColumn:function(){return"Стовпець"},formatOrder:function(){return"Порядок"},formatSortBy:function(){return"Сортувати за"},formatThenBy:function(){return"потім за"},formatSort:function(){return"Сортувати"},formatCancel:function(){return"Скасувати"},formatDuplicateAlertTitle:function(){return"Дублювання стовпців!"},formatDuplicateAlertDescription:function(){return"Видаліть, будь ласка, дублюючий стовпець, або замініть його на інший."}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["uk-UA"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["ur-PK"]={formatLoadingMessage:function(){return"براۓ مہربانی انتظار کیجئے"},formatRecordsPerPage:function(a){return a+" ریکارڈز فی صفہ "},formatShowingRows:function(a,b,c){return"دیکھیں "+a+" سے "+b+" کے "+c+"ریکارڈز"},formatSearch:function(){return"تلاش"},formatNoMatches:function(){return"کوئی ریکارڈ نہیں ملا"},formatRefresh:function(){return"تازہ کریں"},formatToggle:function(){return"تبدیل کریں"},formatColumns:function(){return"کالم"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["ur-PK"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["uz-Latn-UZ"]={formatLoadingMessage:function(){return"Yuklanyapti, iltimos kuting..."},formatRecordsPerPage:function(a){return a+" qator har sahifada"},formatShowingRows:function(a,b,c){return"Ko'rsatypati "+a+" dan "+b+" gacha "+c+" qatorlarni"},formatSearch:function(){return"Qidirish"},formatNoMatches:function(){return"Hech narsa topilmadi"},formatPaginationSwitch:function(){return"Sahifalashni yashirish/ko'rsatish"},formatRefresh:function(){return"Yangilash"},formatToggle:function(){return"Ko'rinish"},formatColumns:function(){return"Ustunlar"},formatAllRows:function(){return"Hammasi"},formatExport:function(){return"Eksport"},formatClearFilters:function(){return"Filtrlarni tozalash"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["uz-Latn-UZ"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["vi-VN"]={formatLoadingMessage:function(){return"Đang tải..."},formatRecordsPerPage:function(a){return a+" bản ghi mỗi trang"},formatShowingRows:function(a,b,c){return"Hiển thị từ trang "+a+" đến "+b+" của "+c+" bảng ghi"},formatSearch:function(){return"Tìm kiếm"},formatNoMatches:function(){return"Không có dữ liệu"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["vi-VN"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["zh-CN"]={formatLoadingMessage:function(){return"正在努力地加载数据中，请稍候……"},formatRecordsPerPage:function(a){return"每页显示 "+a+" 条记录"},formatShowingRows:function(a,b,c){return"显示第 "+a+" 到第 "+b+" 条记录，总共 "+c+" 条记录"},formatSearch:function(){return"搜索"},formatNoMatches:function(){return"没有找到匹配的记录"},formatPaginationSwitch:function(){return"隐藏/显示分页"},formatRefresh:function(){return"刷新"},formatToggle:function(){return"切换"},formatColumns:function(){return"列"},formatExport:function(){return"导出数据"},formatClearFilters:function(){return"清空过滤"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["zh-CN"])}(jQuery),function(a){"use strict";a.fn.bootstrapTable.locales["zh-TW"]={formatLoadingMessage:function(){return"正在努力地載入資料，請稍候……"},formatRecordsPerPage:function(a){return"每頁顯示 "+a+" 項記錄"},formatShowingRows:function(a,b,c){return"顯示第 "+a+" 到第 "+b+" 項記錄，總共 "+c+" 項記錄"},formatSearch:function(){return"搜尋"},formatNoMatches:function(){return"沒有找到符合的結果"},formatPaginationSwitch:function(){return"隱藏/顯示分頁"},formatRefresh:function(){return"重新整理"},formatToggle:function(){return"切換"},formatColumns:function(){return"列"}},a.extend(a.fn.bootstrapTable.defaults,a.fn.bootstrapTable.locales["zh-TW"])}(jQuery);
/**
 * bootbox.js [master branch]
 *
 * http://bootboxjs.com/license.txt
 */

// @see https://github.com/makeusabrew/bootbox/issues/180
// @see https://github.com/makeusabrew/bootbox/issues/186
(function (root, factory) {

  "use strict";
  if (typeof define === "function" && define.amd) {
    // AMD. Register as an anonymous module.
    define(["jquery"], factory);
  } else if (typeof exports === "object") {
    // Node. Does not work with strict CommonJS, but
    // only CommonJS-like environments that support module.exports,
    // like Node.
    module.exports = factory(require("jquery"));
  } else {
    // Browser globals (root is window)
    root.bootbox = factory(root.jQuery);
  }

}(this, function init($, undefined) {

  "use strict";

  // the base DOM structure needed to create a modal
  var templates = {
    dialog:
      "<div class='bootbox modal' tabindex='-1' role='dialog' aria-hidden='true'>" +
        "<div class='modal-dialog'>" +
          "<div class='modal-content'>" +
            "<div class='modal-body'><div class='bootbox-body'></div></div>" +
          "</div>" +
        "</div>" +
      "</div>",
    header:
      "<div class='modal-header'>" +
        "<h4 class='modal-title'></h4>" +
      "</div>",
    footer:
      "<div class='modal-footer'></div>",
    closeButton:
      "<button type='button' class='bootbox-close-button close' data-dismiss='modal' aria-hidden='true'>&times;</button>",
    form:
      "<form class='bootbox-form'></form>",
    inputs: {
      text:
        "<input class='bootbox-input bootbox-input-text form-control' autocomplete=off type=text />",
      textarea:
        "<textarea class='bootbox-input bootbox-input-textarea form-control'></textarea>",
      email:
        "<input class='bootbox-input bootbox-input-email form-control' autocomplete='off' type='email' />",
      select:
        "<select class='bootbox-input bootbox-input-select form-control'></select>",
      checkbox:
        "<div class='checkbox'><label><input class='bootbox-input bootbox-input-checkbox' type='checkbox' /></label></div>",
      date:
        "<input class='bootbox-input bootbox-input-date form-control' autocomplete=off type='date' />",
      time:
        "<input class='bootbox-input bootbox-input-time form-control' autocomplete=off type='time' />",
      number:
        "<input class='bootbox-input bootbox-input-number form-control' autocomplete=off type='number' />",
      password:
        "<input class='bootbox-input bootbox-input-password form-control' autocomplete='off' type='password' />"
    }
  };

  var defaults = {
    // default language
    locale: "en",
    // show backdrop or not. Default to static so user has to interact with dialog
    backdrop: "static",
    // animate the modal in/out
    animate: true,
    // additional class string applied to the top level dialog
    className: null,
    // whether or not to include a close button
    closeButton: true,
    // show the dialog immediately by default
    show: true,
    // dialog container
    container: "body"
  };

  // our public object; augmented after our private API
  var exports = {};

  /**
   * @private
   */
  function _t(key) {
    var locale = locales[defaults.locale];
    return locale ? locale[key] : locales.en[key];
  }

  function processCallback(e, dialog, callback) {
    e.stopPropagation();
    e.preventDefault();

    // by default we assume a callback will get rid of the dialog,
    // although it is given the opportunity to override this

    // so, if the callback can be invoked and it *explicitly returns false*
    // then we'll set a flag to keep the dialog active...
    var preserveDialog = $.isFunction(callback) && callback.call(dialog, e) === false;

    // ... otherwise we'll bin it
    if (!preserveDialog) {
      dialog.modal("hide");
    }
  }

  function getKeyLength(obj) {
    // @TODO defer to Object.keys(x).length if available?
    var k, t = 0;
    for (k in obj) {
      t ++;
    }
    return t;
  }

  function each(collection, iterator) {
    var index = 0;
    $.each(collection, function(key, value) {
      iterator(key, value, index++);
    });
  }

  function sanitize(options) {
    var buttons;
    var total;

    if (typeof options !== "object") {
      throw new Error("Please supply an object of options");
    }

    if (!options.message) {
      throw new Error("Please specify a message");
    }

    // make sure any supplied options take precedence over defaults
    options = $.extend({}, defaults, options);

    if (!options.buttons) {
      options.buttons = {};
    }

    buttons = options.buttons;

    total = getKeyLength(buttons);

    each(buttons, function(key, button, index) {

      if ($.isFunction(button)) {
        // short form, assume value is our callback. Since button
        // isn't an object it isn't a reference either so re-assign it
        button = buttons[key] = {
          callback: button
        };
      }

      // before any further checks make sure by now button is the correct type
      if ($.type(button) !== "object") {
        throw new Error("button with key " + key + " must be an object");
      }

      if (!button.label) {
        // the lack of an explicit label means we'll assume the key is good enough
        button.label = key;
      }

      if (!button.className) {
        if (total <= 2 && index === total-1) {
          // always add a primary to the main option in a two-button dialog
          button.className = "btn-primary";
        } else {
          button.className = "btn-default";
        }
      }
    });

    return options;
  }

  /**
   * map a flexible set of arguments into a single returned object
   * if args.length is already one just return it, otherwise
   * use the properties argument to map the unnamed args to
   * object properties
   * so in the latter case:
   * mapArguments(["foo", $.noop], ["message", "callback"])
   * -> { message: "foo", callback: $.noop }
   */
  function mapArguments(args, properties) {
    var argn = args.length;
    var options = {};

    if (argn < 1 || argn > 2) {
      throw new Error("Invalid argument length");
    }

    if (argn === 2 || typeof args[0] === "string") {
      options[properties[0]] = args[0];
      options[properties[1]] = args[1];
    } else {
      options = args[0];
    }

    return options;
  }

  /**
   * merge a set of default dialog options with user supplied arguments
   */
  function mergeArguments(defaults, args, properties) {
    return $.extend(
      // deep merge
      true,
      // ensure the target is an empty, unreferenced object
      {},
      // the base options object for this type of dialog (often just buttons)
      defaults,
      // args could be an object or array; if it's an array properties will
      // map it to a proper options object
      mapArguments(
        args,
        properties
      )
    );
  }

  /**
   * this entry-level method makes heavy use of composition to take a simple
   * range of inputs and return valid options suitable for passing to bootbox.dialog
   */
  function mergeDialogOptions(className, labels, properties, args) {
    //  build up a base set of dialog properties
    var baseOptions = {
      className: "bootbox-" + className,
      buttons: createLabels.apply(null, labels)
    };

    // ensure the buttons properties generated, *after* merging
    // with user args are still valid against the supplied labels
    return validateButtons(
      // merge the generated base properties with user supplied arguments
      mergeArguments(
        baseOptions,
        args,
        // if args.length > 1, properties specify how each arg maps to an object key
        properties
      ),
      labels
    );
  }

  /**
   * from a given list of arguments return a suitable object of button labels
   * all this does is normalise the given labels and translate them where possible
   * e.g. "ok", "confirm" -> { ok: "OK, cancel: "Annuleren" }
   */
  function createLabels() {
    var buttons = {};

    for (var i = 0, j = arguments.length; i < j; i++) {
      var argument = arguments[i];
      var key = argument.toLowerCase();
      var value = argument.toUpperCase();

      buttons[key] = {
        label: _t(value)
      };
    }

    return buttons;
  }

  function validateButtons(options, buttons) {
    var allowedButtons = {};
    each(buttons, function(key, value) {
      allowedButtons[value] = true;
    });

    each(options.buttons, function(key) {
      if (allowedButtons[key] === undefined) {
        throw new Error("button key " + key + " is not allowed (options are " + buttons.join("\n") + ")");
      }
    });

    return options;
  }

  exports.alert = function() {
    var options;

    options = mergeDialogOptions("alert", ["ok"], ["message", "callback"], arguments);

    if (options.callback && !$.isFunction(options.callback)) {
      throw new Error("alert requires callback property to be a function when provided");
    }

    /**
     * overrides
     */
    options.buttons.ok.callback = options.onEscape = function() {
      if ($.isFunction(options.callback)) {
        return options.callback.call(this);
      }
      return true;
    };

    return exports.dialog(options);
  };

  exports.confirm = function() {
    var options;

    options = mergeDialogOptions("confirm", ["cancel", "confirm"], ["message", "callback"], arguments);

    /**
     * overrides; undo anything the user tried to set they shouldn't have
     */
    options.buttons.cancel.callback = options.onEscape = function() {
      return options.callback.call(this, false);
    };

    options.buttons.confirm.callback = function() {
      return options.callback.call(this, true);
    };

    // confirm specific validation
    if (!$.isFunction(options.callback)) {
      throw new Error("confirm requires a callback");
    }

    return exports.dialog(options);
  };

  exports.prompt = function() {
    var options;
    var defaults;
    var dialog;
    var form;
    var input;
    var shouldShow;
    var inputOptions;

    // we have to create our form first otherwise
    // its value is undefined when gearing up our options
    // @TODO this could be solved by allowing message to
    // be a function instead...
    form = $(templates.form);

    // prompt defaults are more complex than others in that
    // users can override more defaults
    // @TODO I don't like that prompt has to do a lot of heavy
    // lifting which mergeDialogOptions can *almost* support already
    // just because of 'value' and 'inputType' - can we refactor?
    defaults = {
      className: "bootbox-prompt",
      buttons: createLabels("cancel", "confirm"),
      value: "",
      inputType: "text"
    };

    options = validateButtons(
      mergeArguments(defaults, arguments, ["title", "callback"]),
      ["cancel", "confirm"]
    );

    // capture the user's show value; we always set this to false before
    // spawning the dialog to give us a chance to attach some handlers to
    // it, but we need to make sure we respect a preference not to show it
    shouldShow = (options.show === undefined) ? true : options.show;

    /**
     * overrides; undo anything the user tried to set they shouldn't have
     */
    options.message = form;

    options.buttons.cancel.callback = options.onEscape = function() {
      return options.callback.call(this, null);
    };

    options.buttons.confirm.callback = function() {
      var value;

      switch (options.inputType) {
        case "text":
        case "textarea":
        case "email":
        case "select":
        case "date":
        case "time":
        case "number":
        case "password":
          value = input.val();
          break;

        case "checkbox":
          var checkedItems = input.find("input:checked");

          // we assume that checkboxes are always multiple,
          // hence we default to an empty array
          value = [];

          each(checkedItems, function(_, item) {
            value.push($(item).val());
          });
          break;
      }

      return options.callback.call(this, value);
    };

    options.show = false;

    // prompt specific validation
    if (!options.title) {
      throw new Error("prompt requires a title");
    }

    if (!$.isFunction(options.callback)) {
      throw new Error("prompt requires a callback");
    }

    if (!templates.inputs[options.inputType]) {
      throw new Error("invalid prompt type");
    }

    // create the input based on the supplied type
    input = $(templates.inputs[options.inputType]);

    switch (options.inputType) {
      case "text":
      case "textarea":
      case "email":
      case "date":
      case "time":
      case "number":
      case "password":
        input.val(options.value);
        break;

      case "select":
        var groups = {};
        inputOptions = options.inputOptions || [];

        if (!$.isArray(inputOptions)) {
          throw new Error("Please pass an array of input options");
        }

        if (!inputOptions.length) {
          throw new Error("prompt with select requires options");
        }

        each(inputOptions, function(_, option) {

          // assume the element to attach to is the input...
          var elem = input;

          if (option.value === undefined || option.text === undefined) {
            throw new Error("given options in wrong format");
          }

          // ... but override that element if this option sits in a group

          if (option.group) {
            // initialise group if necessary
            if (!groups[option.group]) {
              groups[option.group] = $("<optgroup/>").attr("label", option.group);
            }

            elem = groups[option.group];
          }

          elem.append("<option value='" + option.value + "'>" + option.text + "</option>");
        });

        each(groups, function(_, group) {
          input.append(group);
        });

        // safe to set a select's value as per a normal input
        input.val(options.value);
        break;

      case "checkbox":
        var values   = $.isArray(options.value) ? options.value : [options.value];
        inputOptions = options.inputOptions || [];

        if (!inputOptions.length) {
          throw new Error("prompt with checkbox requires options");
        }

        if (!inputOptions[0].value || !inputOptions[0].text) {
          throw new Error("given options in wrong format");
        }

        // checkboxes have to nest within a containing element, so
        // they break the rules a bit and we end up re-assigning
        // our 'input' element to this container instead
        input = $("<div/>");

        each(inputOptions, function(_, option) {
          var checkbox = $(templates.inputs[options.inputType]);

          checkbox.find("input").attr("value", option.value);
          checkbox.find("label").append(option.text);

          // we've ensured values is an array so we can always iterate over it
          each(values, function(_, value) {
            if (value === option.value) {
              checkbox.find("input").prop("checked", true);
            }
          });

          input.append(checkbox);
        });
        break;
    }

    // @TODO provide an attributes option instead
    // and simply map that as keys: vals
    if (options.placeholder) {
      input.attr("placeholder", options.placeholder);
    }

    if (options.pattern) {
      input.attr("pattern", options.pattern);
    }

    if (options.maxlength) {
      input.attr("maxlength", options.maxlength);
    }

    // now place it in our form
    form.append(input);

    form.on("submit", function(e) {
      e.preventDefault();
      // Fix for SammyJS (or similar JS routing library) hijacking the form post.
      e.stopPropagation();
      // @TODO can we actually click *the* button object instead?
      // e.g. buttons.confirm.click() or similar
      dialog.find(".btn-primary").click();
    });

    dialog = exports.dialog(options);

    // clear the existing handler focusing the submit button...
    dialog.off("shown.bs.modal");

    // ...and replace it with one focusing our input, if possible
    dialog.on("shown.bs.modal", function() {
      // need the closure here since input isn't
      // an object otherwise
      input.focus();
    });

    if (shouldShow === true) {
      dialog.modal("show");
    }

    return dialog;
  };

  exports.dialog = function(options) {
    options = sanitize(options);

    var dialog = $(templates.dialog);
    var innerDialog = dialog.find(".modal-dialog");
    var body = dialog.find(".modal-body");
    var buttons = options.buttons;
    var buttonStr = "";
    var callbacks = {
      onEscape: options.onEscape
    };

    if ($.fn.modal === undefined) {
      throw new Error(
        "$.fn.modal is not defined; please double check you have included " +
        "the Bootstrap JavaScript library. See http://getbootstrap.com/javascript/ " +
        "for more details."
      );
    }

    each(buttons, function(key, button) {

      // @TODO I don't like this string appending to itself; bit dirty. Needs reworking
      // can we just build up button elements instead? slower but neater. Then button
      // can just become a template too
      buttonStr += "<button data-bb-handler='" + key + "' type='button' class='btn " + button.className + "'>" + button.label + "</button>";
      callbacks[key] = button.callback;
    });

    body.find(".bootbox-body").html(options.message);

    if (options.animate === true) {
      dialog.addClass("fade");
    }

    if (options.className) {
      dialog.addClass(options.className);
    }

    if (options.size === "large") {
      innerDialog.addClass("modal-lg");
    } else if (options.size === "small") {
      innerDialog.addClass("modal-sm");
    }

    if (options.title) {
      body.before(templates.header);
    }

    if (options.closeButton) {
      var closeButton = $(templates.closeButton);

      if (options.title) {
        dialog.find(".modal-header").prepend(closeButton);
      } else {
        closeButton.css("margin-top", "-10px").prependTo(body);
      }
    }

    if (options.title) {
      dialog.find(".modal-title").html(options.title);
    }

    if (buttonStr.length) {
      body.after(templates.footer);
      dialog.find(".modal-footer").html(buttonStr);
    }


    /**
     * Bootstrap event listeners; used handle extra
     * setup & teardown required after the underlying
     * modal has performed certain actions
     */

    dialog.on("hidden.bs.modal", function(e) {
      // ensure we don't accidentally intercept hidden events triggered
      // by children of the current dialog. We shouldn't anymore now BS
      // namespaces its events; but still worth doing
      if (e.target === this) {
        dialog.remove();
      }
    });

    /*
    dialog.on("show.bs.modal", function() {
      // sadly this doesn't work; show is called *just* before
      // the backdrop is added so we'd need a setTimeout hack or
      // otherwise... leaving in as would be nice
      if (options.backdrop) {
        dialog.next(".modal-backdrop").addClass("bootbox-backdrop");
      }
    });
    */

    dialog.on("shown.bs.modal", function() {
      dialog.find(".btn-primary:first").focus();
    });

    /**
     * Bootbox event listeners; experimental and may not last
     * just an attempt to decouple some behaviours from their
     * respective triggers
     */

    if (options.backdrop !== "static") {
      // A boolean true/false according to the Bootstrap docs
      // should show a dialog the user can dismiss by clicking on
      // the background.
      // We always only ever pass static/false to the actual
      // $.modal function because with `true` we can't trap
      // this event (the .modal-backdrop swallows it)
      // However, we still want to sort of respect true
      // and invoke the escape mechanism instead
      dialog.on("click.dismiss.bs.modal", function(e) {
        // @NOTE: the target varies in >= 3.3.x releases since the modal backdrop
        // moved *inside* the outer dialog rather than *alongside* it
        if (dialog.children(".modal-backdrop").length) {
          e.currentTarget = dialog.children(".modal-backdrop").get(0);
        }

        if (e.target !== e.currentTarget) {
          return;
        }

        dialog.trigger("escape.close.bb");
      });
    }

    dialog.on("escape.close.bb", function(e) {
      if (callbacks.onEscape) {
        processCallback(e, dialog, callbacks.onEscape);
      }
    });

    /**
     * Standard jQuery event listeners; used to handle user
     * interaction with our dialog
     */

    dialog.on("click", ".modal-footer button", function(e) {
      var callbackKey = $(this).data("bb-handler");

      processCallback(e, dialog, callbacks[callbackKey]);
    });

    dialog.on("click", ".bootbox-close-button", function(e) {
      // onEscape might be falsy but that's fine; the fact is
      // if the user has managed to click the close button we
      // have to close the dialog, callback or not
      processCallback(e, dialog, callbacks.onEscape);
    });

    dialog.on("keyup", function(e) {
      if (e.which === 27) {
        dialog.trigger("escape.close.bb");
      }
    });

    // the remainder of this method simply deals with adding our
    // dialogent to the DOM, augmenting it with Bootstrap's modal
    // functionality and then giving the resulting object back
    // to our caller

    $(options.container).append(dialog);

    dialog.modal({
      backdrop: options.backdrop ? "static": false,
      keyboard: false,
      show: false
    });

    if (options.show) {
      dialog.modal("show");
    }

    // @TODO should we return the raw element here or should
    // we wrap it in an object on which we can expose some neater
    // methods, e.g. var d = bootbox.alert(); d.hide(); instead
    // of d.modal("hide");

   /*
    function BBDialog(elem) {
      this.elem = elem;
    }

    BBDialog.prototype = {
      hide: function() {
        return this.elem.modal("hide");
      },
      show: function() {
        return this.elem.modal("show");
      }
    };
    */

    return dialog;

  };

  exports.setDefaults = function() {
    var values = {};

    if (arguments.length === 2) {
      // allow passing of single key/value...
      values[arguments[0]] = arguments[1];
    } else {
      // ... and as an object too
      values = arguments[0];
    }

    $.extend(defaults, values);
  };

  exports.hideAll = function() {
    $(".bootbox").modal("hide");

    return exports;
  };


  /**
   * standard locales. Please add more according to ISO 639-1 standard. Multiple language variants are
   * unlikely to be required. If this gets too large it can be split out into separate JS files.
   */
  var locales = {
    ar : {
      OK      : "موافق",
      CANCEL  : "الغاء",
      CONFIRM : "تأكيد"
    },
    bg_BG : {
      OK      : "Ок",
      CANCEL  : "Отказ",
      CONFIRM : "Потвърждавам"
    },
    br : {
      OK      : "OK",
      CANCEL  : "Cancelar",
      CONFIRM : "Sim"
    },
    cs : {
      OK      : "OK",
      CANCEL  : "Zrušit",
      CONFIRM : "Potvrdit"
    },
    da : {
      OK      : "OK",
      CANCEL  : "Annuller",
      CONFIRM : "Accepter"
    },
    de : {
      OK      : "OK",
      CANCEL  : "Abbrechen",
      CONFIRM : "Akzeptieren"
    },
    el : {
      OK      : "Εντάξει",
      CANCEL  : "Ακύρωση",
      CONFIRM : "Επιβεβαίωση"
    },
    en : {
      OK      : "OK",
      CANCEL  : "Cancel",
      CONFIRM : "OK"
    },
    es : {
      OK      : "OK",
      CANCEL  : "Cancelar",
      CONFIRM : "Aceptar"
    },
    et : {
      OK      : "OK",
      CANCEL  : "Katkesta",
      CONFIRM : "OK"
    },
    fa : {
      OK      : "قبول",
      CANCEL  : "لغو",
      CONFIRM : "تایید"
    },
    fi : {
      OK      : "OK",
      CANCEL  : "Peruuta",
      CONFIRM : "OK"
    },
    fr : {
      OK      : "OK",
      CANCEL  : "Annuler",
      CONFIRM : "Confirmer"
    },
    he : {
      OK      : "אישור",
      CANCEL  : "ביטול",
      CONFIRM : "אישור"
    },
    hu : {
      OK      : "OK",
      CANCEL  : "Mégsem",
      CONFIRM : "Megerősít"
    },
    hr : {
      OK      : "OK",
      CANCEL  : "Odustani",
      CONFIRM : "Potvrdi"
    },
    id : {
      OK      : "OK",
      CANCEL  : "Batal",
      CONFIRM : "OK"
    },
    it : {
      OK      : "OK",
      CANCEL  : "Annulla",
      CONFIRM : "Conferma"
    },
    ja : {
      OK      : "OK",
      CANCEL  : "キャンセル",
      CONFIRM : "確認"
    },
    lt : {
      OK      : "Gerai",
      CANCEL  : "Atšaukti",
      CONFIRM : "Patvirtinti"
    },
    lv : {
      OK      : "Labi",
      CANCEL  : "Atcelt",
      CONFIRM : "Apstiprināt"
    },
    nl : {
      OK      : "OK",
      CANCEL  : "Annuleren",
      CONFIRM : "Accepteren"
    },
    no : {
      OK      : "OK",
      CANCEL  : "Avbryt",
      CONFIRM : "OK"
    },
    pl : {
      OK      : "OK",
      CANCEL  : "Anuluj",
      CONFIRM : "Potwierdź"
    },
    pt : {
      OK      : "OK",
      CANCEL  : "Cancelar",
      CONFIRM : "Confirmar"
    },
    ru : {
      OK      : "OK",
      CANCEL  : "Отмена",
      CONFIRM : "Применить"
    },
    sq : {
      OK : "OK",
      CANCEL : "Anulo",
      CONFIRM : "Prano"
    },
    sv : {
      OK      : "OK",
      CANCEL  : "Avbryt",
      CONFIRM : "OK"
    },
    th : {
      OK      : "ตกลง",
      CANCEL  : "ยกเลิก",
      CONFIRM : "ยืนยัน"
    },
    tr : {
      OK      : "Tamam",
      CANCEL  : "İptal",
      CONFIRM : "Onayla"
    },
    zh_CN : {
      OK      : "OK",
      CANCEL  : "取消",
      CONFIRM : "确认"
    },
    zh_TW : {
      OK      : "OK",
      CANCEL  : "取消",
      CONFIRM : "確認"
    }
  };

  exports.addLocale = function(name, values) {
    $.each(["OK", "CANCEL", "CONFIRM"], function(_, v) {
      if (!values[v]) {
        throw new Error("Please supply a translation for '" + v + "'");
      }
    });

    locales[name] = {
      OK: values.OK,
      CANCEL: values.CANCEL,
      CONFIRM: values.CONFIRM
    };

    return exports;
  };

  exports.removeLocale = function(name) {
    delete locales[name];

    return exports;
  };

  exports.setLocale = function(name) {
    return exports.setDefaults("locale", name);
  };

  exports.init = function(_$) {
    return init(_$ || $);
  };

  return exports;
}));

/**
 * Query params function for server side pagination
 *
 * @param params
 * @returns {{limit: *, offset: *, search: *}}
 */
function queryParams(params) {
    var toolbar = $('#toolbar');
    params.status = toolbar.find('select[name=status]').val();
    params.search = toolbar.find('input[name=search]').val();
    params.promocode = toolbar.find('input[name=promocode]').val();
    params.promocodes = toolbar.find('select[name=promocodes]').val();
    params.role = toolbar.find('select[name=role]').val();
    params.date_from = $('input[name=date_from]').val();
    params.date_to = $('input[name=date_to]').val();
    params.manager_id = $('select[name=manager]').val();

    return {
        limit: params.limit,
        offset: params.offset,
        sort: params.sort,
        order: params.order,
        search: params.search,
        promocode: params.promocode,
        promocodes: params.promocodes,
        status: params.status,
        role: params.role,
        date_from: params.date_from,
        date_to: params.date_to,
        manager_id: params.manager_id,
    };
}

/**
 * table - variable to contain table
 * route - named of route which have to be prepended to links (for edit / delete / update actions)
 */
var table, route, identifier, app_image, package_name, a_class, span_class, status, appDone, role, locale, currency;

/**
 * Document ready event
 * get table id split it and store in route variable
 * needed for links in formatter
 */
$(document).ready(function () {
    table = $('.table-responsive').find('table.table.table-hover');
    route = table.attr('data-route');
    role = table.attr('data-role');
    locale = table.attr('data-locale') === 'ru-RU' ? 'ru' : 'en';
    currency = table.attr('data-currency');
    var select_status = $('select[name=status]');
    var select_role = $('select[name=role]');
    var select_manager = $('select[name=manager]');
    var select_promocodes = $('select[name=promocodes]');

    if (select_status.attr('id') === 'status') {
        select_status.select2({width: '100%'});
    } else {
        select_status.select2({search: false, minimumResultsForSearch: -1});
    }

    select_status.change(function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });

    select_role.select2({search: false, minimumResultsForSearch: -1});
    select_role.change(function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });

    select_manager.select2();
    select_manager.change(function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });

    $('input[name=search]').on('keyup', function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });

    $('input[name=promocode]').on('keyup', function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });

    select_promocodes.select2();
    select_promocodes.change(function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });

    $('input[name=date_from]').change(function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });

    $('input[name=date_to]').change(function () {
        table.bootstrapTable('refresh', queryParams({silent: true}));
    });
});


function ids(value) {
    return identifier = value;
}

function packages(value) {
    return package_name = value;
}

function statuses_hidden(value) {
    return status = value;
}

function image(value) {
    return app_image = value;
}

function app_names(value, row) {
    var image = row.image;

    if (row.hasOwnProperty('app') && !row.app) {
        return '-';
    }

    if (!image && row.app) {
        // In case if row is Task
        if (row.app.hasOwnProperty('image')) {
            image = row.app.image;
        }
    }

    var app_id = row.application_id ? row.application_id : row.id;

    if (!image) {
        return '<a href="' + route + '/show/' + row.id + '" class="block-link">' +
            '<div class="app-table-group">' +
            '<p>' + value + '</p>' +
            '</div>' +
            '</a>';
    }

    return '<a href="' + route + '/show/' + app_id + '" class="block-link">' +
        '<div class="app-table-group">' +
        '<img src="' + image + '" class="app-img"/>' +
        '<p>' + value + '</p>' +
        '</div>' +
        '</a>';
}

function device_type(value) {
    var device_icon;
    switch (value) {
        case 'android':
            device_icon = '<i class="fa fa-android fa-2x"></i>';
            break;
        case 'ios':
            device_icon = '<i class="fa fa-apple fa-2x"></i>';
            break;
    }
    return device_icon;
}

/**
 * Formatter for table actions button
 * edit/delete
 *
 * @param id
 */
function userActions(id) {
    var info_word = 'Info';
    var delete_word = 'Delete';
    if (locale === 'ru') {
        info_word = 'Информаия';
        delete_word = 'Удалить';
    }

    var info_button = '<a title="' + info_word + '" href="' + route + '/show/' + id + '" class="icon-button user-info-button">' +
        '<div class="edit-user"></div> ' +
        '</a>';

    var delete_button = '<button title="' + delete_word + '" type="button" data-id="' + id + '" ' +
        'class="delete-user del-user icon-button delete-icon">' +
        '</button>';

    return info_button + delete_button;
}

/**
 * Formatter to return edit button
 * @returns {string}
 */
function editFormatter(id) {
    var edit_word = 'Edit';
    if (locale === 'ru') {
        edit_word = 'Редактировать';
    }
    return '<a title="' + edit_word + '" href="' + route + '/edit/' + id + '" class="icon-button">' +
        '<i class="icons8-edit"></i>' +
        '</a>';
}

function done(value) {
    return appDone = value;
}

function app_actions(id, app) {
    var edit_word = 'Edit';
    var start_word = 'Start campaign';
    var pause_word = 'Pause campaign';
    var stats_word = 'Statistics';
    var delete_word = 'Delete';
    if (locale === 'ru') {
        edit_word = 'Редактировать';
        start_word = 'Запустить кампанию';
        pause_word = 'Приостановить кампанию';
        stats_word = 'Статистика';
        delete_word = 'Удалить';
    }

    var edit =
        '<a title="' + edit_word + '" href="' + route + '/edit/' + id + '" class="btn-task-status">' +
        '<div class="actions_items edit"> </div> ' +
        '</a>';

    var start =
        '<a title="' + start_word + '" class=" btn-task-status" ' +
        'data-id="' + app.id + '">' +
        '<div class="actions_items start"> </div>' +
        '</a>';

    if (!app.paid || !app.moderated || !app.accepted || app.done) {
        start =
            '<a title="' + start_word + '" class="btn-task-status not-active">' +
            '<div class="actions_items start"> </div>' +
            '</a>';
    }

    if (app.active) {
        start = '<a title="' + pause_word + '" class=" btn-task-status"' +
            'data-id="' + app.id + '">' +
            '<div class="actions_items start"> </div>' +
            '</a>';
    }

    var stats =
        '<a title="' + stats_word + '" href="' + route + '/show/' + id + '" class="">' +
        '<div class="actions_items stats"> </div>' +
        '</a>';

    var restore = app.paid && (!app.canceled && !app.done);
    var del =
        '<button title="' + delete_word + '" type="button" class="delete actions_items del" ' +
        'data-amount="' + app.amount_for_user + '" data-wasted="' + app.amount_wasted +
        '" data-restore="' + restore + '" data-id="' + id + '">' +
        
        '</button>';

    if (app.paid && !app.moderated) {
        del = '<button title="' + delete_word + '" type="button" class=" not-active">' +
            '<div class="actions_items del"> </div>' +
            '</button>';
    }

    return edit + start + stats + del;
}

function active(value, app) {
    var appId = app.id;
    var apps = sessionStorage.getItem('apps');
    if (apps) {
        apps = JSON.parse(apps);
        if (apps.activate.indexOf(appId) !== -1) {
            value = true;
        } else if (apps.deactivate.indexOf(appId) !== -1) {
            value = false;
        }
    }

    if (value === true) {
        a_class = "btn-success visible";
        span_class = "glyphicon-ok";
    } else {
        a_class = "btn-danger";
        span_class = "glyphicon-remove";
    }
    var disabledBtn = (appDone || !app.moderated || !app.accepted || !app.paid)
    && value === false ? 'disabled data-disabled="true"' : '';

    return '<a data-id=' + identifier + ' class="active active-item btn ' + a_class + '"' + disabledBtn + '><span class="glyphicon ' + span_class + '"></span></a>';
}

/**
 * Formatter for banned state
 *
 * @param value
 * @returns {string}
 */
function banned(value) {
    if (value === 1)
        return '<i title="Пользователь забанен" class="fa fa-2x fa-ban text-danger"></i>';
}

function statusFormatter(value) {
    return '<span class="label label-' + value['class'] + '">' + value['label'] + '</span>';
}

function booleanFormatter(result_success) {
    var icon = '<i class="fa fa-2x fa-times text-danger"></i>';
    if (result_success) {
        return '<i class="fa fa-2x fa-check text-success"></i>';
    }
    return icon;
}

function manualFormatter(value) {
    var icon = null;
    if (value === true) {
        icon = 'fa-hand-paper-o';
    } else {
        icon = 'fa-cogs';
    }
    return '<i class="fa fa-2x ' + icon + '"></i>';
}

function userIdentifierFormatter(id, user) {
    return '<a href="/users/show/' + user.id + '">' + id + '</a>';
}

/**
 * @object object
 * @any value
 * @returns {string}
 */
function getKeyByValue(object, value) {
    return Object.keys(object).find(function (key) {
        return object[key] === value
    });
}

/**
 * Formatter for displaying all users who did task
 *
 * @param index
 * @param value
 * @returns {string}
 */
function detailFormatter(index, value) {
    var data = "";
    $.each(value.users_list, function (index, val) {
        data += '<div class="well well-sm primary">' + val.name + ' ' + val.email + ' ' + val.date + '</div>';
    });
    return data;
}

function amount(value) {
    return '<b>' + value + " " + currency + '</b>';
}

/**
 * Deleting record from table
 */
$('body').on('click', '.delete', function () {
    var self = $(this);
    var id = self.attr('data-id');
    var message = 'Are You sure that You want delete application?';

    var app_amount = self.data('amount');
    var restore = self.data('restore');

    if (restore) {
        var old_balance = parseFloat($('#balance-value').html());
        var wasted = parseFloat(self.data('wasted'));
        var to_restore = app_amount - wasted;
        var new_balance = old_balance + to_restore;
    }

    if (locale === 'ru') {
        message = 'Вы уверены, что хотите удалить приложение?';
    }
    bootbox.confirm(message, function (result) {
        if (result) {
            $.ajax({
                url: route + '/edit/' + id,
                type: 'DELETE',
                success: function () {
                    table.bootstrapTable('refresh');
                    if (restore) {
                        $('#balance-value').html(new_balance.toFixed(2));
                    }
                },
                error: function () {
                    new Noty({
                        type: 'warning',
                        timeout: 4000,
                        text: 'Can not delete application',
                    }).show();
                }
            });
        }
    });
});