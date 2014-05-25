# Remote Markdown For WordPress

This plugin adds a shortcode that allows to include contents in your posts and pages from a remote markdown-formatted file. It supports Github Flavored Markdown and is meant to synchronize your app documentation from your GitHub or Bitbucket repo to your website, without having the need to update both.

**Current stable version:** [1.0](http://github.com/andrezrv/wp-remote-markdown/tree/1.0)

## Usage

```
[remote-markdown refresh="60"]https://raw.githubusercontent.com/andrezrv/wp-remote-markdown/master/README.md[/remote-markdown]
```

Once loaded for the first time, a [transient](http://codex.wordpress.org/Transients_API) will be created with the expiration (in seconds) specified in the `refresh` property. That will prevent your site from doing a lot of unnecessary requests while the remote file is not being updated. A value of zero, or not using the parameter, will prevent the creation of the transient.

## Installation

1. Clone with `git clone git@github.com:andrezrv/wp-remote-markdown.git` or download and unzip `wp-remote-markdown.zip` into your `/wp-content/plugins/` directory.
2. Activate the plugin through the **"Plugins"** menu in WordPress.

## Contributing
If you feel like you want to help this project by adding something you think useful, you can make your pull request against the master branch :)

## Credit Where Credit is Due

This plugin makes use of the Emanuil Rusev's [Parsedown](https://github.com/erusev/parsedown) PHP library for Markdown parsing, and [Google Code Prettify]((https://code.google.com/p/google-code-prettify/)) for language syntax highlighting.

## Changelog

#### 1.0
First public release.
