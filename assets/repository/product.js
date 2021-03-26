export async function getProductByEAN13(ean) {
    const response = await fetch('/api/product/search?ean=' + ean)
    return response.json()
}

export async function updateProduct(id, product) {
    const response = await fetch('/api/product/' + id, {body: JSON.stringify(product), method: 'POST'})
    return response.json()
}