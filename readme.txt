=== Remote Markdown for WordPress ===
Contributors: andrezrv
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=B7XQG5ZA36UZ4
Tags: github, bitbucket, markdown, remote, parse, syntax
Requires at least: 3.0
Tested up to: 3.9.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Include contents in your WordPress posts and pages from a remote markdown-formatted file.

== Description ==

This plugin adds a shortcode that allows to include contents in your posts and pages from a remote markdown-formatted file. It supports Github Flavored Markdown and is meant to synchronize your app documentation from your GitHub or Bitbucket repo to your website, without having the need to update both.

### Usage

`
[remote-markdown refresh="60"]https://raw.githubusercontent.com/andrezrv/wp-remote-markdown/master/README.md[/remote-markdown]
`

Once loaded for the first time, a [transient](http://codex.wordpress.org/Transients_API) will be created with the expiration (in seconds) specified in the `refresh` property. That will prevent your site from doing a lot of unnecessary requests while the remote file is not being updated. A value of zero, or not using the parameter, will prevent the creation of the transient.

### Contribute

You can make suggestions and submit your own modifications to this plugin on [Github](https://github.com/andrezrv/wp-remote-markdown).

### Credit Where Credit is Due

This plugin makes use of the Emanuil Rusev's [Parsedown](https://github.com/erusev/parsedown) PHP library for Markdown parsing, and [Google Code Prettify]((https://code.google.com/p/google-code-prettify/)) for language syntax highlighting.

== Installation ==

1. Unzip `wp-remote-markdown.zip` and upload the `wp-remote-markdown` folder to your `/wp-content/plugins/` directory.
2. Activate the plugin through the **"Plugins"** menu in WordPress.

== Changelog ==

= 1.0 =
First public release.
