import React from "react";
import {
    Button,
    FormControl,
    IconButton,
    Input,
    InputAdornment,
    InputLabel,
    TextField,
    Typography
} from "@mui/material";
import {Visibility, VisibilityOff} from "@mui/icons-material";
import InputCustom from "../elemets/input/InputCustom"
import InputPassword from "../elemets/input/InputPassword"
import InputPhoneNumber from "../elemets/input/InputPhoneNumber";

const RegistrationForm = ({setAuthData, loading}) => {
    const handleSubmit = (event) => {
        event.preventDefault();

        const data = {
            email: event.target.email.value,
            password: event.target.password.value,
            name: event.target.name.value,
            surname: event.target.surname.value,
            phoneNumber: event.target.phoneNumber.value,
        }

        setAuthData(data);
    };

    return (
        <form className="auth-form" onSubmit={handleSubmit}>
            <Typography variant="h4" component="h1">
                Create account
            </Typography>

            <InputCustom
                id="name"
                type="text"
                label="First name"
                name="name"
                required
            />

            <InputCustom
                id="surname"
                type="text"
                label="Last name"
                name="surname"
                required
            />

            <InputCustom
                id="email"
                type="email"
                label="E-mail"
                name="email"
                required
            />

            <InputPhoneNumber
                name="phoneNumber"
                label=""
            />

            <InputPassword
                id="password"
                name="password"
            />

            <Button
                variant="contained"
                type="submit"
                disabled={loading}
            >
                Sign In
            </Button>
        </form>
    );
};

export default RegistrationForm;