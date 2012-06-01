<?php

class FlexsliderHelper extends AppHelper {

	var $helpers = array(
		'Html',
		'Js',
		'Gallery.Gallery',
		);

	function assets($options = array()) {
	}

	function album($album, $photos) {
		$tag = $this->Html->tag('ul', $photos, array(
				'class' => 'slides'
				));
		return $this->Html->div('flexslider', $tag, array(
			'id' => 'gallery-' . $album['Album']['id'],
			));
	}

	function photo($album, $photo) {
		$urlOrigin = $this->Html->url('/' . $photo['original']);
		$result = $this->Html->image($urlOrigin);
		$tag = $this->Html->tag('li', $result);
		return $tag;
	}

	function initialize($album) {
		$config = $this->Gallery->getAlbumJsParams($album);
		$js = sprintf('$(\'.flexslider\').flexslider(%s);',
			$config
			);
		$this->Js->buffer($js);
	}

}
