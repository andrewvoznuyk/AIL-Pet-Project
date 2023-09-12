import axios from "axios";
import {responseStatus} from "./consts";
import {storageGetItem, storageSetItem, TOKEN} from "../storage/storage";

const loginRequest = (authData, onSuccess, onError, onFinally) => {
    axios.post(`/api/login-check`, authData).then(response => {
        if (response.status === responseStatus.HTTP_OK && response.data.token) {
            storageSetItem(TOKEN, response.data.token);
            onSuccess();
        }
    }).catch(error => {
        onError(error.response.data.message);
    }).finally(() => onFinally());
}

export default loginRequest;