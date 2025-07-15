const svgFiles = import.meta.glob('/resources/js/assets/**/*.{svg,SVG}', {
  query: '?raw',
  import: 'default'
})

export async function useAsset(filename) {
  for (const [path, loader] of Object.entries(svgFiles)) {
    if (path.endsWith(`/${filename}`)) {
      return await loader()
    }
  }
  console.warn(`Icon '${filename}' nicht gefunden`)
  return '<!-- Icon not found -->'
}
