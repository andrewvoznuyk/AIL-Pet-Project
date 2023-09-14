import React, {useContext, useEffect, useState} from "react";
import axios from "axios";
import {
    Breadcrumbs, Button,
    FormControl,
    Input,
    InputLabel,
    Link,
    MenuItem,
    Select,
    TextField,
    Typography
} from "@mui/material";
import {responseStatus} from "../../utils/consts";
import userAuthenticationConfig from "../../utils/userAuthenticationConfig";
import InputCustom from "../elemets/input/InputCustom";

const PlaneForm = ({currentPlane}) => {

    return (
        <>
            <TextField label="Brand" id="Brand" type="text" name="Brand" defaultValue={currentPlane.brand} style={{margin:10}} required/>
            <TextField label="Name" id="Name" type="text" name="Name" defaultValue={currentPlane.plane} style={{margin:10}} required/>
            <TextField label="Engine" id="Engine" type="text" name="Engine" defaultValue={currentPlane.engine} style={{margin:10}} required/>
            <TextField label="Passenger count" type="number" id="price[gte]" name="price[gte]" defaultValue={currentPlane.passenger_capacity} style={{margin:10}}/>
            <img src={currentPlane.imgThumb} alt=""/>
            <Button type="submit" style={{margin:10}}>Add Plane</Button>
        </>
    );
};

export default PlaneForm;