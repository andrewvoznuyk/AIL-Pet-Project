import {
    Breadcrumbs,
    Button,
    FormControl,
    InputLabel,
    Link,
    MenuItem,
    Select,
    TextField,
    Typography
} from "@mui/material";
import {useEffect, useState} from "react";

const PlaneForm = ({currentPlane,data,setData}) => {
    const [places,setPlaces]=useState({
        economPlaces:currentPlane.passenger_capacity,
        businessPlaces:0,
        standardPlaces:0,
    });

    useEffect(()=>{
        setData({...data,places:{"econom":parseInt(places.economPlaces), "standard":parseInt(places.standardPlaces) ,"business":parseInt(places.businessPlaces)}});
    },[places]);

    return (
        <>
            <TextField label="Brand" id="Brand" type="text" name="Brand" value={currentPlane.brand} style={{margin:10}} required/>
            <TextField label="Name" id="Name" type="text" name="Name" value={currentPlane.plane} style={{margin:10}} required/>
            <TextField label="Engine" id="Engine" type="text" name="Engine" value={currentPlane.engine} style={{margin:10}} required/>
            <TextField label="Passenger count" type="number" id="passengers" name="passengers" defaultValue={currentPlane.passenger_capacity} style={{margin:10}}/>
            <div>
                <TextField label="Business places" type="number" id="business" name="business" defaultValue={places.businessPlaces} onChange={(event)=>{setPlaces({...places, businessPlaces: event.target.value})}} style={{margin:10}}/>
                <TextField label="Econom places" type="number" id="econom" name="econom" defaultValue={places.economPlaces} onChange={(event)=>{setPlaces({...places, economPlaces: event.target.value})}} style={{margin:10}}/>
                <TextField label="Standard places" type="number" id="standard" name="standard" defaultValue={places.standardPlaces} onChange={(event)=>{setPlaces({...places, standardPlaces: event.target.value})}} style={{margin:10}}/>
            </div>
            <TextField label="Input plane number" type="text" id="planeNum" name="planeNum" onChange={(event)=>{setData({...data, serialNumber:event.target.value})}} style={{margin:10}}/>
            <img src={currentPlane.imgThumb} alt=""/>
            <Button type="submit" style={{margin:10}}>Add Plane</Button>
        </>
    );
};

export default PlaneForm;