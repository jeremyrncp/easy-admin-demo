import { Controller } from 'stimulus';
import {updateProduct} from "../repository/product";

export default class extends Controller {
    static values = {
        id: Number,
    }
    static targets = [ "container", "name", "description", "image", "price", "newPrice", "submitButton" ]

    connect() {
        this.containerTarget.style.display = "none";
    }

    updatePrice() {
        this.submitButtonTarget.className = "d-block";

        updateProduct(this.idValue, {
            'price': this.newPrice
        })
        .then(result => {
            this.updateData({detail: JSON.stringify(result.result)})
        })
        .catch(err => {
            console.log(err)
        })
        .finally(() => {
        this.submitButtonTarget.className = "d-none";
        })
    }

    updateData(event) {
        const data = JSON.parse(event.detail)
        this.idValue=data.id
        this.nameTarget.innerHTML=data.name
        this.descriptionTarget.innerHTML=data.description
        this.priceTarget.innerHTML=data.price
        this.imageTarget.src= "uploads/images/products/" + data.image

        this.containerTarget.style.display = "block";
    }

    get newPrice() {
        return this.newPriceTarget.value
    }
}
