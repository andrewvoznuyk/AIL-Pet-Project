import React from "react";
import {
    Box,
    Button,
    Grid,
    Link,
    Typography
} from "@mui/material";
import GlobalRegistrationItems from "./GlobalRegistrationItems";


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
        <Box
            sx={{
                marginTop: 8,
                display: 'flex',
                flexDirection: 'column',
                alignItems: 'center',
            }}
        >
            <Grid container>
                <Grid item xs={11} lg={5} sx={{margin: "auto"}}>
                    <form className="auth-form" onSubmit={handleSubmit}>
                        <Typography variant="h4" component="h1">
                            Create account
                        </Typography>

                        <GlobalRegistrationItems />

                        <Button
                            variant="contained"
                            type="submit"
                            disabled={loading}
                        >
                            Sign Up
                        </Button>

                        <Grid container spacing={2}>
                            <Grid item>
                                <Link href="/login" variant="body2">
                                    {"Already have an account? Sign In"}
                                </Link>
                            </Grid>
                        </Grid>
                    </form>
                </Grid>
            </Grid>
        </Box>
    );
};

export default RegistrationForm;