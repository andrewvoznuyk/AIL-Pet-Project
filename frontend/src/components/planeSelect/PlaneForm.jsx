import {useContext, useEffect, useState} from "react";
import axios from "axios";
import {Breadcrumbs, FormControl, InputLabel, Link, MenuItem, Select, TextField, Typography} from "@mui/material";
import {responseStatus} from "../../utils/consts";
import userAuthenticationConfig from "../../utils/userAuthenticationConfig";

const PlaneForm = ({currentPlane}) => {

    return (
        <>
            <Typography gutterBottom variant="h5" component="div">
                {currentPlane.plane}
            </Typography>
            <Typography gutterBottom variant="h5" component="div">
                {currentPlane.brand}
            </Typography>
            <img src={currentPlane.imgThumb} alt=""/>
        </>
    );
};

export default PlaneForm;