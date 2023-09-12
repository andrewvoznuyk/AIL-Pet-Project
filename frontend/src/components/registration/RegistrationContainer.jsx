import {useContext, useEffect, useState} from "react";
import {NavLink, useNavigate} from "react-router-dom";
import axios from "axios";
import {Helmet} from "react-helmet-async";
import {Breadcrumbs, Link, Typography} from "@mui/material";
import Notification from "../elemets/notification/Notification";
import {authentication} from "../../utils/authenticationRequest";
import {responseStatus} from "../../utils/consts";
import {AppContext} from "../../App";
import loginRequest from "../../utils/loginRequest";
import RegistrationForm from "./RegistrationForm";
import {storageSetItem, TOKEN} from "../../storage/storage";

const RegistrationContainer = () => {
    const navigate = useNavigate();

    const {setAuthenticated, authenticated} = useContext(AppContext);

    const [authData, setAuthData] = useState();
    const [error, setError] = useState(null);
    const [loading, setLoading] = useState(false);
    const [notification, setNotification] = useState({
        visible: false,
        type: "",
        message: ""
    });

    const registrationRequest = () => {

        if (!authData) {
            return;
        }

        setLoading(true);

        axios.post(`/api/registration`, authData).then(response => {
            if (response.status === responseStatus.HTTP_OK) {
                //login immediately after registration
                console.log("registered...")
                loginRequest(authData,
                    () => {
                        setAuthenticated(true);
                        console.log("and logged!")
                    });
            }
        }).catch(error => {
            console.log(error.response.data)
            setError(error.response.data.detail);
            setNotification({...notification, visible: true, type: "error", message: error.response.data.detail});
        }).finally(() => setLoading(false));
    };

    useEffect(() => {
        registrationRequest();
    }, [authData]);

    useEffect(() => {
        authentication(navigate, authenticated);
    }, [authenticated]);

    return (
        <>
            {notification.visible &&
                <Notification
                    notification={notification}
                    setNotification={setNotification}
                />
            }
            <Helmet>
                <title>
                    Create account
                </title>
            </Helmet>
            <RegistrationForm
                setAuthData={setAuthData}
                loading={loading}
            />
        </>
    );
};

export default RegistrationContainer;