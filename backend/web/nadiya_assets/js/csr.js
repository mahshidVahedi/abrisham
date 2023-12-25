class CSR{

    target;
    targetId;
    targetType;
    btn;
    btnId;
    type;
    formId;
    searchTitleEl;
    submitEl;
    liveSearchResultEl;

    constructor(targetQuery , btnQuery = null) {
        this.target     = $(targetQuery);
        this.targetId   = this.target.attr('id');
        this.targetType = this.target.data('type');
        if(btnQuery){
            this.btn        = $(btnQuery);
            this.btnId      = this.btn.attr('id');
        }
        this.type       = $(this.target).data('type');
        this.formId     = `content-store-selector-${this.targetId}`;

        this.preparingStyles();
        this.preparingForm();

        this.searchTitleEl      = $(`#${this.formId}-search-title`);
        this.submitEl           = $(`#${this.formId}-submit`);
        this.liveSearchResultEl = $(`#${this.formId}-return_livesearch`);

        this.preparingEvents();
        this.preparingScript();
    }

    get checkFormExist(){
        return $(`#${this.formId}`).length;
    }

    async preparingForm(forceGetForm = false){
        if(forceGetForm || !this.checkFormExist){
            $('body').append(`
                        <div id="${this.formId}" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close pull-left" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">ارجاع از پایگاه دانش</h4>
                                    </div>
                                    <div class="modal-body" style="max-height: 60vh; overflow: auto">
                                        <div class="form-group">
                                            <input id="${this.formId}-search-title" class="form-control type_search" placeholder="">
                                            <ul class="list-group livesearch" id="${this.formId}-return_livesearch" style="display: none"></ul>
                                            <div id="${this.targetId}tree_box" class="m-t-5"></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="form-group">
                                            <button class="btn btn-white" type="button" data-dismiss="modal">بستن</button>
                                            <button id="${this.formId}-submit" class="btn btn-primary" type="button">ثبت</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
            if(!this.btn){
                if(this.targetType == 'ck'){
                    const btnHtml = `<a style="cursor:pointer;padding: 5px;color: white !important;margin-left: 5px;float: left;" id="${this.targetId}-csr_starter" class="cke_toolbar btn btn-xs btn-primary csr-starter"><span class="gl gl-education glyphicon glyphicon-education" style="color: white;cursor:pointer;"></span></a>`;
                    $(`#cke_${this.targetId} .cke_top`).append(btnHtml);
                }
                else{
                    const btnHtml = `<a style="position: absolute;bottom: 15px;left: 15px;display:none;" class="btn btn-xs btn-primary csr-starter" id="${this.targetId}-csr_starter"><i class="fa far fa-graduation-cap gl gl-education glyphicon glyphicon-education"></i></a>`;
                    this.target.after(btnHtml);
                }
                this.btnId = `${this.targetId}-csr_starter`;
                this.btn = $(`#${this.btnId}`);
            }
            this.btn.parent().css('position' , 'relative');
        }
    }


    preparingStyles(){
        if(!$('#cs-styles').length) {
            $('head').append(`
            <style id="cs-styles" type="text/css">
                .livesearch{
                    box-shadow: 1px 2px 10px 5px rgba(147, 147, 147, 0.2);
                    display: block;
                    position: absolute;
                    z-index: 101;
                    width: 100%;
                    border-bottom-left-radius: 5px;
                    border-bottom-right-radius: 5px;
                }
                .livesearch li{
                    cursor: pointer;
                    transition: all 0.5s;
                    margin-top: 0px !important;
                    margin-bottom: 0px !important;
                }
                .livesearch li:hover{
                    background-color: rgb(224,224,224) !important;
                    transition: all 0.3s;
                }

                .type_search.selected{
                    color : green;
                    font-weight: 500;
                }
                .type_search{
                    transition: all 0.3s;
                }
                .jstree-open > .jstree-anchor > .jstree-icon.fa-folder::before{
                  content: '\\f07c' !important;
                }
                
                .jstree-default .jstree-clicked {
                  background: rgba(203, 213, 211, 0.4);
                  box-shadow: none;
                }
                .jstree-default .jstree-clicked ,
                .jstree-default .jstree-hovered {
                  padding-right: 5px;
                  padding-left: 8px;
                }
                .jstree-default .jstree-anchor {
                  transition: .3s;
                }
                .jstree-node[aria-level="1"] > .jstree-anchor{
                    color : #31927a;
                }
                .jstree-node[aria-level="2"] > .jstree-anchor{
                    color : #5375d0;
                }
                .jstree-node[aria-level="3"] > .jstree-anchor{
                    color : #a54747;
                }
                .jstree-node[aria-level="4"] > .jstree-anchor{
                    color : #3896a8;
                }
                .jstree-node[aria-level="5"] > .jstree-anchor{
                    color : #826c2b;
                }
                .jstree-node[aria-level="6"] > .jstree-anchor{
                    color : #5d419c;
                }
                .jstree-node[aria-level="7"] > .jstree-anchor{
                    color : #95308b;
                }
                .jstree-node-subset-info{
                    display: none;
                }
                .jstree-anchor:hover .jstree-node-subset-info{
                    display: inline-block;
                }
                
                
                .content-store-title-box:hover{
                    color: bold;
                }
            </style>
        `);
        }
    }

    preparingScript(){
        if(!$.isFunction($.fn.jstree)) {
            $('<link/>', {
                rel: 'stylesheet',
                type: 'text/css',
                href: '/new/backend/web/nadiya_assets/plugins/jstree/style.css'
            }).appendTo('head');
            $.getScript('/new/backend/web/nadiya_assets/plugins/jstree/jstree.min.js');
            $.getScript('/new/backend/web/nadiya_assets/pages/jquery.tree.js');
        }
    }

    preparingEvents(){
        var _this = this;
        this.searchTitleEl.on('keyup' , function () {
            _this.cleanSelectedCS();
            if($(this).val().trim().length < 3)
            {
                _this.liveSearchResultEl.html('').show();
                return false;
            }
            _this.liveSearchResultEl.html('<li class="list-group-item"><i class="fa fa-spin fa-spinner"></i> در حال جستجو ...</li>').show();
            $.ajax({
                url: '/new/backend/web/content-store/ajax',
                type: 'post',
                data: {
                    type : 'searchContentStore',
                    title : this.value
                },
                success: function (value) {
                    var searchItems = [];

                    for(var item of value){
                        searchItems.push(`<li class="list-group-item user-selector" data-id="${item.id}" data-title="${item.title}">${item.title}</li>`);
                    }
                    if(!searchItems.length)
                        searchItems.push(`<li class="list-group-item">موردی یافت نشد!</li>`);

                    _this.liveSearchResultEl.html(searchItems.join('')).show();
                },
                error: function () {
                    _this.liveSearchResultEl.html('').show();
                },
                complete: function () {
                }
            });
        });
        this.submitEl.on('click' , function () {
            _this.addReferToTarget();
        });
        this.liveSearchResultEl.on("click" , "li" , function(){
            _this.setSelectedCS($(this).data("id"),$(this).data("title"));
        });
        this.searchTitleEl.on('blur' , function(){
            setTimeout(function(){
                _this.liveSearchResultEl.html("").hide();
            } , 200);
        });
        this.btn.on('click' , function () {
            _this.showForm();
        });
        $(`#${this.formId}`).on('click' , '.jstree-anchor[data-iscontent="true"]' , function () {
            const   title = $(this).find('.content-store-title-box').text(),
                id = $(this).closest('.jstree-node').attr('id').split('_')[2];
            _this.setSelectedCS(id,title);
        });
        this.target.on('focus' , function () {
            _this.btn.show();
        });
        this.target.on('blur' , function () {
            _this.btn.fadeOut();
        });
    }

    preparingCSRTree() {
        if($(`#${this.targetId}csr_tree`).length){
            // $('#csr_tree').jstree(true).refresh();
            return false;
        }
        $(`#${this.targetId}tree_box`).html(`<div id="${this.targetId}csr_tree"></div>`);
        $(`#${this.targetId}csr_tree`).jstree({
            'sort' : function(a, b) {
                const a1 = this.get_node(a);
                const b1 = this.get_node(b);
                if (a1.icon == b1.icon){
                    return (a1.text > b1.text) ? 1 : -1;
                } else {
                    if(a1.type == 'add')
                        return -1;
                    return (a1.icon < b1.icon) ? 1 : -1;
                }
            },
            "core": {
                "check_callback": true,
                'data': {
                    url : '/new/backend/web/content-store/ajax',
                    type: 'post',
                    'data': function (node) {
                        var info = node.id.split('_');
                        if(info[0] == 'store' || node.id == '#'){
                            return {
                                type            : 'getContentStores',
                                organizationId  : null,
                                isEditable      : 0,
                                contentStoreId  : info[1]
                            };
                        }
                    }
                }
            },
            types : {'#':{'valid_children' : ['store']} , 'store' : { 'valid_children' : ['content','store','add'] }, 'add' : {'valid_children' : false},'content':{'valid_children' : false} },
            "plugins": [
                "sort",
                "types",
            ]
        });
    }


    setSelectedCS(id,title){
        this.searchTitleEl
            .data("id" , id)
            .data("title" , title)
            .val(title)
            .addClass("selected");
    }

    cleanSelectedCS(id,title){
        this.searchTitleEl
            .data("id" , null)
            .data("title" , null)
            .removeClass("selected");
    }

    addReferToTarget(){
        let csId = this.searchTitleEl.data('id');
        let csTitle = this.searchTitleEl.data('title');
        if(csId){
            let CSRTemplate =`#CSR{{${csId},${csTitle}}}CSR`;
            switch (this.targetType) {
                case 'ck' :
                    CKEDITOR.instances[this.targetId].insertText(CSRTemplate+'\n');
                    break;
                case 'editable' :
                    this.target.append(`<div>${CSRTemplate}</div><div><br></div>`);
                    this.target.trigger('click').trigger('keyup');
                    break;
                case 'textarea' :
                    this.target.val(this.target.val().trim() + (this.target.val().trim() ? '\n' : '') + CSRTemplate);
                    break;
            }
            $(`#${this.formId}`).modal('hide');
        }
        else{
            $.Notification.notify('error','bottom right','خطا!','ابتدا انتخاب نمایید!');
        }
    }

    showForm(){
        this.preparingCSRTree();
        this.preparingForm();
        $(`#${this.formId}`).modal('show');
    }

}

function CSREncode(text) {
    while(true){
        match = text.match(/#CSR\{\{(.*?)\}\}CSR/);
        if(match && match.length){
            info = match[1].split(',');
            CSRTemplate = `<div class='csr-preview'><a target='_blank' href='/site/content/${info[0]}'><i class='fa far fa-graduation-cap glyphicon glyphicon-education'></i> ${info[1]}</a></div>`;
            text = text.replace(match[0] , CSRTemplate);
        }
        else{
            break;
        }
    }
    return text;
}
function CSRDecode(text , isTextRetrun = false) {
    clone = $(text).clone();
    clone.find('.csr-preview').each(function () {
        var CSTitle = $(this).text();
        var splited = $(this).find('a').attr('href').split('/')
        var CSId = splited[splited.length-1];
        var CSRTemplate = `#CSR{{${CSId.trim()},${CSTitle.trim()}}}CSR`;
        $(this).replaceWith(`<div>${CSRTemplate}</div>`);
    });
    if(isTextRetrun)
        return $('<div />').append(clone).text().trim();
    else
        return $('<div />').append(clone).html();
}
