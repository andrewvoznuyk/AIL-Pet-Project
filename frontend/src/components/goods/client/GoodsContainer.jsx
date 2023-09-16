import { Breadcrumbs, Button, Grid, Link, Typography } from "@mui/material";
import React from "react";
import {Helmet} from "react-helmet-async";
import {NavLink} from "react-router-dom";
import InitTicketSearch from "../../elemets/input/inputGroup/InitTicketSearch";

const GoodsContainer = () => {
    return (
        <>
            <Helmet>
                <title>
                    Goods
                </title>
            </Helmet>

            <Breadcrumbs aria-label="breadcrumb">
                <Link component={NavLink} underline="hover" color="inherit" to="/">
                    Home
                </Link>
                <Typography color="text.primary">Goods</Typography>
            </Breadcrumbs>
            <Typography variant="h4" component="h1" mt={1}>
                Goods
            </Typography>
            <Grid container>
              <Button
                to="/panel/goods/cooperation"
                component={NavLink}
              >
                Cooperation
              </Button>
            </Grid>
        </>
    );
};

export default GoodsContainer;