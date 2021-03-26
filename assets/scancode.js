import {BrowserCodeReader, BrowserMultiFormatReader} from '@zxing/browser';
import {getProductByEAN13} from "./repository/product";

const idVideo = 'scancode';
const state = {
    barcode: null
};

const getProductData = (ean) => {
    getProductByEAN13(ean)
        .then(result => {
            window.dispatchEvent(new CustomEvent("json-data", {detail: JSON.stringify(result.result)}))
        })
        .catch(err => {
            addDebug(err)
        })
}

const cleanVideoAndDecode = (selectedDeviceId) => {
    BrowserMultiFormatReader.cleanVideoSource(document.querySelector('#' + idVideo));
    decode(new BrowserMultiFormatReader, selectedDeviceId, getProductData);
}

const decode = (codeReader, selectedDeviceId, callback) => {
    codeReader
        .decodeOnceFromVideoDevice(selectedDeviceId, idVideo)
        .then((result) => {
            callback(result.getText())
            state.barcode = result.getText();
            const classList = document.querySelector("#scancode-result").classList;
            classList.remove("d-none");

            document.querySelector("#scancode-result").innerHTML = "EAN : " + state.barcode

            cleanVideoAndDecode(selectedDeviceId);
        })
        .catch((err) => {
            if (err) {
                addDebug(err.message)
            }
        })
}

const addDebug = (msg) => {
    document.querySelector('#scancode-debug').innerHTML = msg;
}


window.addEventListener('load', function () {
    let selectedDeviceId;
    const deviceSelect = document.querySelector("#device")

    deviceSelect.onchange = () => {
        cleanVideoAndDecode(deviceSelect.value);
    };

    BrowserCodeReader.listVideoInputDevices()
        .then((videoInputDevices) => {
            selectedDeviceId = videoInputDevices[0].deviceId
            if (videoInputDevices.length >= 1) {
                videoInputDevices.forEach((element) => {
                    const sourceOption = document.createElement('option')
                    sourceOption.text = element.label
                    sourceOption.value = element.deviceId
                    deviceSelect.appendChild(sourceOption)
                })
            }

            decode(new BrowserMultiFormatReader(), selectedDeviceId);
        })
        .catch((err) => {
            console.error(err)
        })
})