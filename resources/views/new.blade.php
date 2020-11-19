
<!DOCTYPE html>
<html>
    <head>
    	<!-- http://mbraak.github.io/jqTree/ -->
        <meta charset="utf-8" />
        <title>jqTree</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="JqTree is a jQuery widget for displaying a tree structure in html" />
        <script src="{{ url('/') }}/new/jquery-3.5.1.min.js"></script>
		<script src="{{ url('/') }}/new/tree.jquery.js"></script>
		<link rel="stylesheet" href="{{ url('/') }}/new/jqtree.css">
		<link rel="stylesheet" href="{{ url('/') }}/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    </head>
    <body>

    	<div id="tree1"></div>
    	<div id="tree2"></div>
    	<div id="tree3"></div>


    <script>

    var data2 = [
	    {
	        "name": "Saurischia",
	        "id": 1,
	        "load_on_demand": true
	    },
	    {
	        "name": "Ornithischians",
	        "id": 23,
	        "load_on_demand": true
	    }
	];
	var data = [
	    {
	        name: 'node1',
	        children: [
	            { name: 'child1',
	            	children: [
	            		{ name: 'child55' },
	            		{ name: 'child66' },
	            	]
	            },
	            { name: 'child2' }
	        ]
	    },
	    {
	        name: 'node2',
	        children: [
	            { name: 'child3' }
	        ]
	    }
	];

	var data3 = [
	  {
	    name: '<a href="example1.html">examples</a>',
	      children: [
	        { name: '<a href="example1.html">Example 1</a>' },
	        { name: '<a href="example2.html">Example 2</a>' },
	        '<a href="example3.html">Example </a>'
	      ]
	  }
	];

	$(function() {
	    

	    $('#tree2').tree({
	        data: data2,
	    });
	    $('#tree3').tree({
	        data: data3,
	        autoEscape: false,
  			autoOpen: true
	    });

	    var $tree = $('#tree1');
	    $tree.tree({
	        data: data,
	        dragAndDrop: true,
  			autoOpen: 0,
  			// rtl: true,
  			closedIcon: $('<i class="fas fa-plus"></i>'),
    		openedIcon: $('<i class="fas fa-minus"></i>'),
    		dataFilter: function(data) {
		        // Example:
		        // the server puts the tree data in 'my_tree_data'
		        return '<span class="badge badge-info right">' + data + '</span>';
		        // return data;
		    }
	    });

	    $tree.on( 'tree.click', function(e) {
		    // Disable single selection
		    e.preventDefault();
		    var selected_node = e.node;

		    if (selected_node.id === undefined) {
		        console.warn('The multiple selection functions require that nodes have an id');
		    }

		    if ($tree.tree('isNodeSelected', selected_node)) {
		        $tree.tree('removeFromSelection', selected_node);
		    } else {
		        $tree.tree('addToSelection', selected_node);
		    }
		});
	});

	</script>
    </body>
</html>
