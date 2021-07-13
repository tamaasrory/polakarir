<template>
  <div
    id="webviewer"
    ref="viewer"
  />
</template>

<script>
import WebViewer from '@pdftron/webviewer'

export default {
  name: 'WebViewer',
  props: {
    initialDoc: { type: [Blob, String], required: true },
    filename: { type: String, required: true }
  },
  data () {
    return {
      viewer: null,
      path: null
    }
  },
  mounted () {
    this.viewer = this.$refs.viewer
    this.path = `${process.env.BASE_URL}webviewer`
    WebViewer({
      path: this.path,
      enableAnnotations: false,
      isReadOnly: true,
      css: require('@/assets/bpp-style.css')
    }, this.viewer)
      .then(instance => {
        instance.disableElements(['ribbons'])
        instance.disableTools(['all'])
        instance.loadDocument(this.initialDoc, { filename: this.filename })
      })
  }
}
</script>

<style>
#webviewer {
  height: auto;
}
</style>
