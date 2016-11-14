
(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href=".html">Ghostly</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Ghostly_Core" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Ghostly/Core.html">Core</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Ghostly_Core_Ghostly" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Ghostly/Core/Ghostly.html">Ghostly</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Ghostly_Exceptions" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Ghostly/Exceptions.html">Exceptions</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Ghostly_Exceptions_CannotConnectToDatabaseException" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Ghostly/Exceptions/CannotConnectToDatabaseException.html">CannotConnectToDatabaseException</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "Ghostly.html", "name": "Ghostly", "doc": "Namespace Ghostly"},{"type": "Namespace", "link": "Ghostly/Core.html", "name": "Ghostly\\Core", "doc": "Namespace Ghostly\\Core"},{"type": "Namespace", "link": "Ghostly/Exceptions.html", "name": "Ghostly\\Exceptions", "doc": "Namespace Ghostly\\Exceptions"},
            
            {"type": "Class", "fromName": "Ghostly\\Core", "fromLink": "Ghostly/Core.html", "link": "Ghostly/Core/Ghostly.html", "name": "Ghostly\\Core\\Ghostly", "doc": "&quot;This class is the base from which the data models will extend.&quot;"},
                                                        {"type": "Method", "fromName": "Ghostly\\Core\\Ghostly", "fromLink": "Ghostly/Core/Ghostly.html", "link": "Ghostly/Core/Ghostly.html#method___construct", "name": "Ghostly\\Core\\Ghostly::__construct", "doc": "&quot;Constructs a new Ghostly object with the specified database connection parameters.&quot;"},
                    {"type": "Method", "fromName": "Ghostly\\Core\\Ghostly", "fromLink": "Ghostly/Core/Ghostly.html", "link": "Ghostly/Core/Ghostly.html#method_close", "name": "Ghostly\\Core\\Ghostly::close", "doc": "&quot;Closes the open database connection. If a connection is not open this method\ndoes nothing.&quot;"},
            
            {"type": "Class", "fromName": "Ghostly\\Exceptions", "fromLink": "Ghostly/Exceptions.html", "link": "Ghostly/Exceptions/CannotConnectToDatabaseException.html", "name": "Ghostly\\Exceptions\\CannotConnectToDatabaseException", "doc": "&quot;This class represents an exception that is thrown when the Ghostly ORM cannot\nconnect to the configured database environment.&quot;"},
                                                        {"type": "Method", "fromName": "Ghostly\\Exceptions\\CannotConnectToDatabaseException", "fromLink": "Ghostly/Exceptions/CannotConnectToDatabaseException.html", "link": "Ghostly/Exceptions/CannotConnectToDatabaseException.html#method___construct", "name": "Ghostly\\Exceptions\\CannotConnectToDatabaseException::__construct", "doc": "&quot;Constructs a new CannotConnectToDatabaseException object with an optional\nmessage.&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


