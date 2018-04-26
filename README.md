#PHP Html Template System

##Usage

##Html

###Including files
`#include file`
When the file is loaded by the php class `Html`, any `file` will be replaced by the content of $dir/includes/file.html
Note: ".html" is automatically appended to `file`.

###Required values
`#{name}`
When `#{name}` is used, you *must* use the php code `$html->set($name, $value)`. This would replace `#{name}` with `$value`. If `$html->set($name, $value)` is not used. `#{name}" will be displayed once the html is shown in the browser.

###Optional values
`?{name}`
When using html such as `<div class="nav-link"></div>` and you may need to add another class such as `nav-link-selected` for the page you are on, you can use the html `<div class="nav-link ?{linkSelected}"></div>`.
By using this, when the HTML is rendered, every existence of ``<div class="nav-link ?{linkSelected}` will be replaced with `<div class="nav-link"></div>`. If you wish to add `nav-link-selected`, then you would run the php code `$html->setOptional("linkSelected", "nav-link-selected")`. This would then render `"<div class="nav-link nav-link-selected></div>"`.

##PHP
###Loading HTML templates
`$html = new Html($dir="", $name="");`
Loads a HTML file in the directory $dir and name as $name.
This also loads any includes that are in the HTML code.
###Example:
If the HTML template is called `main.html` and is in the relative directory `templates/`, '$html = new Html("templates", "main")' would load that file into `$html`. 
Note: notice `main` was parsed as $name and not `main.html`. This is because ".html" is *always* appended to `$name`.


###Setting values
##Required value
`$html->set("title", "Homepage");`
This code will replace `#{title}` with the string `Homepage` in the loaded html.
Note: if required values (`#{name}`) is not set, `#{name}` will be displayed in the output

##Optional values
$html->setOptional("pageSelected", "nav-selected");
The above code will set the optional variable `?{pageSelected}` to "nav-selected".
This function is used for setting optional values (`?{name}`). If the optional value is not set, `#?{name}` will simply be removed from the html
