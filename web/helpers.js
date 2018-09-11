    /**
     * Relative path
     * Returns the derived relative path from one to the other.
     *
     * Usage:
     *     {{relative from to}}
     */
    Handlebars.registerHelper('relative', function(from, to) {
      var relativePath = path.relative(from, to);

      relativePath = Utils.urlNormalize(path.relative( 
        path.resolve(path.join(dest, relative)), 
        path.resolve(relativePath) 
      ));

      return relativePath;
    });


    /**
     * absolute
     * Returns the absolute path to the current directory. 
     *
     * Usage:
     *     {{absolute}}
     *     
     * Returns:
     *     C:\path\to\the\current\current\directory
     */
    Handlebars.registerHelper('absolute', function(absolute) {
      var absolute = __filename;
      return absolute;
    });

    /**
     * Basename
     * Returns the basename of a given file. 
     *
     * Usage:
     *     {{base "docs/toc.md"}}
     *     
     * Returns:
     *     toc
     */
    Handlebars.registerHelper('basename', function(base, ext) {
      var fullName = path.basename(base, ext);
      base = path.basename(base, path.extname(fullName))
      return base;
    });
    // Same as above.
    // Handlebars.registerHelper('basename', function(name, noExtension) {
    //   if (typeof(noExtension) !== 'undefined') 
    //     return path.basename(name).split('.')[0];
    //   return path.basename(name);
    // });


    /**
     * Filename
     * Returns the filename of a given file. 
     *
     * Usage:
     *     {{filename "docs/toc.md"}}
     *     
     * Returns:
     *     toc.md
     */
    Handlebars.registerHelper('filename', function(base, ext) {
      var filename = path.basename(base, ext)
      return filename;
    });

    /**
     * Extension
     * Returns the extension of a given file. 
     *
     * Usage:
     *     {{ext "docs/toc.md"}}
     *     
     * Returns:
     *     .md
     */
    Handlebars.registerHelper('ext', function(ext) {
      var extension = path.extname(ext);

      return extension;
    });

