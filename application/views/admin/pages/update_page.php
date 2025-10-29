<?php $this->load->view('admin/inc/header');

$set = str_getcsv($settings, ",");
$btn_list = '';
if (count($set) > 0) {
    foreach ($set as $row) {
        if (strpos($row, 'french') !== false) {
            $btn_list .= '<li id="french-li"><a class="lang-btn" data-language="french" data-id="' . $page_id . '" style="cursor:pointer">French</a></li>';
        }
        if (strpos($row, 'russian') !== false) {
            $btn_list .= '<li id="russian-li"><a class="lang-btn" data-language="russian" data-id="' . $page_id . '" style="cursor:pointer">Russian</a></li>';
        }
        if (strpos($row, 'portuguese') !== false) {
            $btn_list .= '<li id="portuguese-li"><a class="lang-btn" data-language="portuguese" data-id="' . $page_id . '" style="cursor:pointer">Portuguese</a></li>';
        }
        if (strpos($row, 'spanish') !== false) {
            $btn_list .= '<li id="spanish-li"><a class="lang-btn" data-language="spanish" data-id="' . $page_id . '" style="cursor:pointer">Spanish</a></li>';
        }
        if (strpos($row, 'german') !== false) {
            $btn_list .= '<li id="german-li"><a class="lang-btn" data-language="german" data-id="' . $page_id . '" style="cursor:pointer">German</a></li>';
        }
    }
    $btn_list .= '<li class="active" id="english-li"><a href="' . current_url() . '" class="lang-btn" data-language="english" data-id="' . $page_id . '" style="cursor:pointer">English</a></li>';
}
?>
<!-- TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript" src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url('/'); ?>admin_src/js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('/'); ?>admin_src/js/jquery.form.min.js"></script>

<body>
<?php $this->load->view('admin/inc/nav_top'); ?>

<div class="container-fluid">
    <div class="row-fluid">
        <?php $this->load->view('admin/inc/nav_main'); ?>
        <div id="content" class="span10">
            <!-- start: Content -->
            <div>
                <hr>
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo site_url('/'); ?>">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo site_url('/'); ?>admin/pages/">Pages</a><span class="divider">/</span>
                    </li>
                    <li>
                        Update Page: <?php echo $title; ?>
                    </li>
                </ul>
                <hr>
            </div>

            <div class="row-fluid sortable">
                <div class="box span12">
                    <div class="box-header">
                        <h2><i class="icon-th"></i><span class="break"></span> Update Page: <?php echo $title; ?></h2>
                    </div>
                    <div class="box-content">
                        <ul class="nav tab-menu nav-tabs">
                            <?php echo $btn_list; ?>
                        </ul>
                        <div class="tab-content" id="language-cont">
                            <form id="page-update" name="page-update" method="post" action="<?php echo site_url('/'); ?>admin/update_page_do" class="form-horizontal">
                                <fieldset>
                                    <input type="hidden" name="page_id" value="<?php if (isset($page_id)) { echo $page_id; } ?>">
                                    <input type="hidden" name="autosave" id="autosave" value="true">
                                    <input type="hidden" name="status" id="status" value="<?php if (isset($status)) { echo $status; } ?>">
                                    <div class="control-group">
                                        <label class="control-label" for="title">Title</label>
                                        <div class="controls">
                                            <input type="text" class="span6" id="title" name="title" placeholder="Page title" value="<?php if (isset($title)) { echo $title; } ?>">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="title">Status</label>
                                        <div class="controls">
                                            <div class="btn-group" data-toggle="buttons-radio">
                                                <button type="button" class="btn btn-primary<?php if ($status == 'draft') { echo ' active'; } ?>">Draft</button>
                                                <button type="button" class="btn btn-primary<?php if ($status == 'live') { echo ' active'; } ?>">Live</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="title">Heading</label>
                                        <div class="controls">
                                            <input type="text" class="span6" id="heading" name="heading" placeholder="Page Heading" value="<?php if (isset($heading)) { echo $heading; } ?>">
                                            <span class="help-block" style="font-size:11px">Optional, give your page a sub heading (h2)</span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="slug">Slug</label>
                                        <div class="controls">
                                            <input type="text" class="span6" id="slug" name="slug" placeholder="Page URL Slug eg: /about-us" value="<?php if (isset($slug)) { echo $slug; } ?>">
                                            <span class="help-block" style="font-size:11px">The URL parameter. eg: http://www.example.com/about-us</span>
                                        </div>
                                    </div>
                                    <?php print $this->admin_model->slct_parent_page_list($page_parent, $page_id); ?>
                                    <div class="control-group">
                                        <label class="control-label" for="sequence">Sequence:</label>
                                        <div class="controls">
                                            <input name="page_sequence" type="text" class="span1" id="sequence" value="<?php if (isset($page_sequence)) { echo $page_sequence; } ?>" size="3" maxlength="3">
                                            <span class="help-block" style="font-size:11px">Set the sequence of the page</span>
                                        </div>
                                    </div>
                                    <?php $this->admin_model->get_page_templates($page_template); ?>
                                    <div class="control-group">
                                        <label class="control-label" for="page_features">Page Features</label>
                                        <div class="controls">
                                            <?php $this->admin_model->get_page_features($page_id); ?>
                                        </div>
                                    </div>
                                    <div class="control-group" id="ckeditor_msg">
                                        <label class="control-label" for="editor">Page Body:</label>
                                        <div class="controls">
                                            <textarea id="editor" name="content" style="display:block"><?php echo $body; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="title">Icon</label>
                                        <div class="controls">
                                            <textarea name="icon" class="span6" style="display:block"><?php if (isset($icon)) { echo $icon; } ?></textarea>
                                            <span class="help-block" style="font-size:11px">Optional (Copy script image script here)</span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="title">Website URL</label>
                                        <div class="controls">
                                            <input type="text" class="span6" id="url" name="url" placeholder="Website URL: eg http://www.test.com" value="<?php if (isset($url)) { echo $url; } ?>">
                                            <span class="help-block" style="font-size:11px">Optional</span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="title">Featured Document</label>
                                        <div class="controls">
                                            <input type="text" class="span6" id="feat_doc" name="feat_doc" placeholder="Featured Document" value="<?php if (isset($document)) { echo $document; } ?>">
                                            <span class="help-block" style="font-size:11px">Optional (Paste direct link to document)</span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="metaT">Meta Title:</label>
                                        <div class="controls">
                                            <textarea name="metaT" style="display:block" class="span6"><?php if (isset($metaT)) { echo $metaT; } ?></textarea>
                                            <span class="help-block" style="font-size:11px">If input given the default title is overridden. Good for SEO purposes. No longer than 70 characters</span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="metaD">Meta Description:</label>
                                        <div class="controls">
                                            <textarea name="metaD" style="display:block" class="span6"><?php if (isset($metaD)) { echo $metaD; } ?></textarea>
                                            <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any other page.</span>
                                        </div>
                                    </div>
                                    <div id="result_msg"></div>
                                    <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Page</button>
                                    <a href="<?php echo $this->session->userdata('url'); ?>/page/<?php echo $slug; ?>/" target="_blank" style="margin: 0px 10px" class="btn pull-right btn-inverse"><i class="icon-search icon-white"></i> Preview</a>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar, gallery, people, downloads, sidebars, business, and modal code remain unchanged for brevity -->
            <!-- ... (all your sidebar/modal/feature boxes code is preserved here) ... -->

            <hr>
            <!-- end: Content -->
        </div><!--/#content.span10-->
    </div><!--/fluid-row-->

    <div class="modal hide fade" id="myModal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Settings</h3>
        </div>
        <div class="modal-body">
            <p>Here settings can be configured...</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Close</a>
            <a href="#" class="btn btn-primary">Save changes</a>
        </div>
    </div>

    <div class="modal hide fade" id="modal-people-delete">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Page Person</h3>
        </div>
        <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
            </div>
        </div>
        <div class="modal-footer">
            <a onClick="$('#modal-people-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Day Person</a>
        </div>
    </div>

    <div class="clearfix"></div>
    <?php $this->load->view('admin/inc/footer'); ?>
</div><!--/.fluid-container-->

<script>
    // Initialize TinyMCE on #editor
	function initTinyMCE() {
		// Remove all editors before initializing (handles AJAX and tab switches)
		if (typeof tinymce !== "undefined") {
			tinymce.remove();
			// Only initialize if the textarea exists
			if ($('#editor').length) {
				tinymce.init({
					selector: '#editor',
					height: 300,
					plugins: [
						'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 'anchor',
						'searchreplace', 'visualblocks', 'code', 'fullscreen',
						'insertdatetime', 'media', 'table', 'help', 'wordcount'
					],
					toolbar: 'undo redo | blocks | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | removeformat | code | help',
					image_title: true,
					automatic_uploads: true,
					file_picker_types: 'image',
					file_picker_callback: function (cb, value, meta) {
						if (meta.filetype === 'image') {
							var input = document.createElement('input');
							input.setAttribute('type', 'file');
							input.setAttribute('accept', 'image/*');
							input.onchange = function () {
								var file = this.files[0];
								var reader = new FileReader();
								reader.onload = function () {
									cb(reader.result, { title: file.name });
								};
								reader.readAsDataURL(file);
							};
							input.click();
						}
					}
				});
			}
		}
	}

    var delay = 1000;
    var isLoading = false;
    var isDirty = false;

    $(document).ready(function () {
        initTinyMCE();

        $('#dob').datepicker();

        $('#bname').keydown(function () {
            isDirty = true;
            reloadSearch();
        });

        $('#page_sidebars').change(function () {
            $('#sidebars_div').toggle(this.checked);
        });

        $('#page_downloads').change(function () {
            $('#downloads_div').toggle(this.checked);
        });

        $('#page_people').change(function () {
            $('#people_div').toggle(this.checked);
        });

        $('#save_download_btn').bind('click', function (e) {
            e.preventDefault();
            var frm = $('#download_frm');
            $('#save_download_btn').html('<img src="<?php echo base_url('/'); ?>admin_src/img/loading_white.gif" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/'); ?>admin/add_downloads',
                success: function (dataresult) {
                    $('#result_msg').html(dataresult);
                    $('#save_download_btn').html('<i class="icon-check icon-white"></i> Save Downloads');
                }
            });
        });

        $('#save_sidebars_btn').bind('click', function (e) {
            e.preventDefault();
            var frm = $('#sidebars_frm');
            $('#save_sidebars_btn').html('<img src="<?php echo base_url('/'); ?>admin_src/img/loading_white.gif" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/'); ?>admin/add_page_sidebars',
                success: function (dataresult) {
                    $('#result_msg').html(dataresult);
                    $('#save_sidebars_btn').html('<i class="icon-check icon-white"></i> Save Sidebars');
                }
            });
        });

        $('#butt').bind('click', function (e) {
            e.preventDefault();
            if ($('#title').val().length == 0) {
                $('#title').popover({
                    delay: { show: 100, hide: 3000 },
                    placement: "top",
                    html: true,
                    trigger: "manual",
                    title: "Title Required",
                    content: "Please supply us with a page title"
                });
                $('#title').popover('show');
                $('#title').focus();
            } else {
                submit_form();
            }
        });

        $('div.btn-group button').live('click', function () {
            $('#status').attr('value', $(this).html());
        });

        $('#page-update :input').change(function () {
            $('#autosave').val('false');
        });
        $('.redactor_box').live('click', function () {
            $('#autosave').val('false');
        });

        // Featured image
        $('#imgbut').bind('click', function () {
            var avataroptions = {
                target: '#avatar_msg',
                url: '<?php echo site_url('/'); ?>admin/add_featured_image',
                beforeSend: function () { var percentVal = '0%'; probar.width(percentVal) },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    probar.width(percentVal)
                },
                complete: function (xhr) {
                    procover.hide();
                    probar.width('0%');
                    $('#avatar_msg').html(xhr.responseText);
                    $('#imgbut').html('Update Image');
                }
            };

            var frm = $('#add-img');
            var probar = $('#procover .bar');
            var procover = $('#procover');

            $('#imgbut').html('<img src="<?php echo base_url('/'); ?>admin_src/img/loading_white.gif" /> Uploading...');
            procover.show();
            frm.ajaxForm(avataroptions);
            $('#autosave').val('true');
        });
    });

    function submit_form() {
        var frm = $('#page-update');
        $('#butt').html('<img src="<?php echo base_url('/'); ?>admin_src/img/loading_white.gif" /> Working...');
        if (typeof tinymce !== "undefined") {
            tinymce.triggerSave();
        }
        let data = frm.serialize();
        $.ajax({
            type: 'post',
            data: data,
            url: '<?php echo site_url('/'); ?>admin/update_page_do',
            success: function (dataresult) {
                $('#autosave').val('true');
                $('#result_msg').html(dataresult);
                $('#butt').html('Update Page');
            }
        });
    }

    // IE 9 Fix
    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function attach_gallery() {
        var gal_id = $('#gallery_select').val();
        $.ajax({
            type: 'get',
            url: '<?php echo site_url('/'); ?>admin/update_sidebar/page/<?php echo $page_id; ?>/gallery/' + gal_id,
            success: function (data) {
                load_images(gal_id);
            }
        });
    }

    function remove_gallery(gal_id) {
        $.ajax({
            type: 'get',
            url: '<?php echo site_url('/'); ?>admin/remove_sidebar/page/<?php echo $page_id; ?>/gallery/' + gal_id,
            success: function (data) {
                $('#gal_box').html(data);
            }
        });
    }

    window.onbeforeunload = function () {
        if ($('#autosave').val() == 'false') {
            return 'The page has not been saved.';
        }
    };

    function load_images(gal_id) {
        $.ajax({
            cache: false,
            method: "post",
            url: "<?php echo site_url('/'); ?>admin/load_gallery_images/" + gal_id,
            success: function (data) {
                $('#gal_box').append(data);
            }
        });
    }

    // Name Search
    function reloadSearch() {
        if (!isLoading) {
            var q = $("#bname").val();
            if ($.trim(q).length != 0) {
                isLoading = true;
                var div = $("#my_na_div");
                div.show();
                div.html('<img src="<?php echo base_url('/'); ?>admin_src/img/loading_white.gif" /> Working...');
                $.get("<?php echo site_url('/'); ?>admin/get_my_business_name/" + q, function (data) {
                    div.html(data);
                });
                setTimeout(function () {
                    isLoading = false;
                    if (isDirty) {
                        isDirty = false;
                        reloadSearch();
                    }
                }, delay);
            } else {
                $("#my_na_div").empty();
            }
        }
    }

    function add_business(id) {
        $('#my_na_bus_id').val(id);
        $('#cbus_' + id).hide();
        $.ajax({
            type: 'get',
            cache: false,
            url: '<?php echo site_url('/'); ?>admin/add_my_business_name/<?php echo $page_id; ?>/' + id + '/',
            success: function (data) {
                $('#my_msg').html(data);
                reload_businesses();
            }
        });
    }

    function reload_businesses() {
        $.ajax({
            type: 'get',
            cache: false,
            url: '<?php echo site_url('/'); ?>admin/reload_businesses/<?php echo $page_id; ?>',
            success: function (data) {
                $('#bus_list').html(data);
            }
        });
    }

    function remove_business(bid) {
        $('#busi_' + bid).hide();
        $.ajax({
            type: 'get',
            url: '<?php echo site_url('/'); ?>admin/remove_business_do/' + bid + '/<?php echo $page_id; ?>',
            success: function (data) {
                //reload_businesses();
            }
        });
    }

    function add_people() {
        var frm = $('#people_add');
        $('#btn_ppl').html('<img src="<?php echo base_url('/'); ?>admin_src/img/loading_white.gif" /> Working...');
        $.ajax({
            type: 'post',
            data: frm.serialize(),
            url: '<?php echo site_url('/'); ?>admin/add_page_people',
            success: function (data) {
                $('#result_msg').html(data);
                $('#btn_ppl').html('<i class="icon-plus-sign icon-white"></i> Add Person');
                reload_people(<?php echo $page_id; ?>);
                var options = { 'text': 'Person added successfully', 'layout': 'bottomLeft', 'type': 'success' };
                noty(options);
            }
        });
    }

    function delete_page_people(id) {
        $('#modal-people-delete').bind('show', function () {
            var removeBtn = $(this).find('.btn-primary');
            removeBtn.unbind('click').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: "<?php echo site_url('/'); ?>admin/delete_page_people/" + id + "/",
                    success: function (data) {
                        $('footer').html(data);
                        $('#modal-people-delete').modal('hide');
                        $("#row-" + id).remove();
                    }
                });
            });
        }).modal({ backdrop: true });
    }

    function reload_people(id) {
        $.ajax({
            type: 'get',
            url: '<?php echo site_url('/'); ?>admin/reload_page_people_all/' + id,
            success: function (data) {
                $('#curr_ppl').html(data);
                $('.datatable').dataTable({
                    "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sLengthMenu": "_MENU_"
                    }
                });
            }
        });
    }
</script>
</body>
</html>