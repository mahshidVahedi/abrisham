/**
 * Theme: Ubold Admin Template
 * Author: Coderthemes
 * Tree view
 */

$( document ).ready(function() {
    // Basic
    $('#basicTree').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}
		},
        'types' : {
            'briefcase' : {
                'icon' : 'gl gl-briefcase'
            },
            'book' : {
                'icon' : 'gl gl-book'
            },
            'folder' : {
                'icon' : 'gl gl-folder-open'
            },
            'duplicate' : {
                'icon' : 'gl gl-duplicate'
            },
            'file' : {
                'icon' : 'gl gl-file'
            },
            'plus' : {
                'icon' : 'gl gl-plus-sign'
            }
        },
        'plugins' : ['types']
    });
    
    // Checkbox
    $('#checkTree').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}
		},
        'types' : {
            'briefcase' : {
                'icon' : 'gl gl-briefcase'
            },
            'book' : {
                'icon' : 'gl gl-book'
            },
            'folder' : {
                'icon' : 'gl gl-folder-open'
            },
            'duplicate' : {
                'icon' : 'gl gl-duplicate'
            },
            'file' : {
                'icon' : 'gl gl-file'
            },
            'plus' : {
                'icon' : 'gl gl-plus-sign'
            }
        },
        'plugins' : ['types', 'checkbox']
    });
    
    // Drag & Drop
    $('#dragTree').jstree({
		'core' : {
			'check_callback' : true,
			'themes' : {
				'responsive': false
			}
		},
        'types' : {
            'briefcase' : {
                'icon' : 'gl gl-briefcase'
            },
            'book' : {
                'icon' : 'gl gl-book'
            },
            'folder' : {
                'icon' : 'gl gl-folder-open'
            },
            'duplicate' : {
                'icon' : 'gl gl-duplicate'
            },
            'file' : {
                'icon' : 'gl gl-file'
            },
            'plus' : {
                'icon' : 'gl gl-plus-sign'
            }
        },
        'plugins' : ['types', 'dnd']
    });
    
    // Ajax
    $('#ajaxTree').jstree({
		'core' : {
			'check_callback' : true,
			'themes' : {
				'responsive': false
			},
            'data' : {
                'url' : function (node) {
                    return node.id === '#' ? 'assets/plugins/jstree/ajax_roots.json' : 'assets/plugins/jstree/ajax_children.json';
                },
                'data' : function (node) {
                    return { 'id' : node.id };
                }
            }
        },
        'types' : {
            'briefcase' : {
                'icon' : 'gl gl-briefcase'
            },
            'book' : {
                'icon' : 'gl gl-book'
            },
            'folder' : {
                'icon' : 'gl gl-folder-open'
            },
            'duplicate' : {
                'icon' : 'gl gl-duplicate'
            },
            'file' : {
                'icon' : 'gl gl-file'
            },
            'plus' : {
                'icon' : 'gl gl-plus-sign'
            }
        },
        "plugins" : [ "contextmenu", "dnd", "search", "state", "types", "wholerow" ]
    });
});