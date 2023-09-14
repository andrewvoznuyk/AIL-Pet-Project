import {useContext, useEffect, useState} from "react";
import {NavLink, useNavigate} from "react-router-dom";
import axios from "axios";
import {Helmet} from "react-helmet-async";
import {Breadcrumbs, Link, Typography} from "@mui/material";
import LoginForm from "./LoginForm";
import Notification from "../elemets/notification/Notification";
import {authentication} from "../../utils/authenticationRequest";
import {responseStatus} from "../../utils/consts";
import {AppContext} from "../../App";
import loginRequest from "../../utils/loginRequest";

const Login = () => {
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

    const authenticationRequest = () => {
        if (!authData) {
            return;
        }

        setLoading(true);

        loginRequest(authData,
            () => {
                setAuthenticated(true);
            },
            (message) => {
                setError(message);
                setNotification({...notification, visible: true, type: "error", message: message});
            },
            () => {
                setLoading(false);
            });
    };

    useEffect(() => {
        authenticationRequest();
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
                    Sign in
                </title>
            </Helmet>
            <Breadcrumbs aria-label="breadcrumb">
                <Link component={NavLink} underline="hover" color="inherit" to="/">
                    Home
                </Link>
                <Typography color="text.primary">Sign In</Typography>
            </Breadcrumbs>
            <LoginForm
                setAuthData={setAuthData}
                loading={loading}
            />
        </>
    );
};

export default Login;