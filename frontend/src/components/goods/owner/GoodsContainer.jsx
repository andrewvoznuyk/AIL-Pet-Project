import {Breadcrumbs, Grid, Link, Typography} from "@mui/material";
import React from "react";
import {Helmet} from "react-helmet-async";
import {NavLink} from "react-router-dom";
import InitTicketSearch from "../../elemets/input/inputGroup/InitTicketSearch";
import PlaneSelectForm from "../../planeSelect/PlaneSelectForm";

const GoodsContainer = () => {
    return (
        <>
            <PlaneSelectForm/>
        </>
    );
};

export default GoodsContainer;