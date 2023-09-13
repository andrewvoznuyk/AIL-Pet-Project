import React from "react";
import {
    Button,
    FormControl, Grid,
    IconButton,
    Input,
    InputAdornment,
    InputLabel, Link,
    TextField,
    Typography
} from "@mui/material";
import {Visibility, VisibilityOff} from "@mui/icons-material";
import InputPassword from "../elemets/input/InputPassword";

const LoginForm = ({setAuthData, loading}) => {
    const handleSubmit = (event) => {
        event.preventDefault();

        setAuthData({
            email: event.target.email.value,
            password: event.target.password.value
        });
    };

    const [showPassword, setShowPassword] = React.useState(false);

    const handleClickShowPassword = () => setShowPassword((show) => !show);

    return (
        <form className="auth-form" onSubmit={handleSubmit}>
            <Typography variant="h4" component="h1">
                Sign in!
            </Typography>
            <TextField
                variant="standard"
                id="email"
                type="email"
                label="E-mail"
                name="email"
                required
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
            <Grid container spacing={2}>
                <Grid item>
                    <Link href="/register" variant="body2">
                        {"Doesn't have an account? Sign Up"}
                    </Link>
                </Grid>
            </Grid>

        </form>
    )
        ;
};

export default LoginForm;