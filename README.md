# StreamHitching
Framework to easily implement custom streams

When working with stream wrappers it isn't always easy to maintain a good class architecture nor to be sure to have implemented all required methods.

For most use cases you need to components to write a stream wrapper.

1. Code that *translates* the stream URL into a native service URL enriching it with information about the service i.e. *flickr://user/photoid* could translated to *http://farm5.static.flickr.com/userid/photoid.jpg*
2. Code that implements the appropriate methods for the native access. For the above this would be *HTTP*.

StreamHitching uses a simple yet effective class architecture that allows you separate these two components.

![YUML class diagram](http://bit.ly/StreamHitchingClassDiagram "Basic class diagram")

## ``Stream_Wrapper_Decorator``

``Stream_Wrapper_Decorator`` is the class that can be registered as a stream wrapper upon its configuration.

``
$sourceFilter = new Stream_SourceFilter_Flickr(array('protocol' => 'flickr'));
$sourceFilter = new Stream_SourceFilter_Mock(array(
  'protocol' => 'flickr',
  'wrapper_class' => 'Stream_Wrapper_ReadOnlyFile_HTTP'
));
Stream_Wrapper_Decorator::registerWith($sourceFilter);
``

This will register the wrapper for *flickr://* streams (just an example and not yet existent..) decorating the native *HTTP* stream.

## ``Stream_SourceFilter_XXX``

In your ``Stream_SourceFilter_XXX`` you can implement the translation part by implementing the methods ``decode()`` and ``encode()`` which translate the custom stream URL into the native URL and back.


## ``Stream_Wrapper_ReadOnlyFile_XXX``

So far there are only two classes implementing ``Stream_Wrapper_ReadOnlyFile_Interface``.

*  ``Stream_Wrapper_ReadOnlyFile_HTTP`` - providing read only access to a file over HTTP
*  ``Stream_Wrapper_ReadOnlyFile_Local`` - providing read only access to a file on the local file system


All code is PHPUnit tested!
