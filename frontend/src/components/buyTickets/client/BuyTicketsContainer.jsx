import { Breadcrumbs, Button, Grid, Link, Typography } from "@mui/material";
import React, { useEffect, useState } from "react";
import {Helmet} from "react-helmet-async";
import { NavLink, useParams } from "react-router-dom";
import InitTicketSearch from "../../elemets/input/inputGroup/InitTicketSearch";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { responseStatus } from "../../../utils/consts";
import Sidebar from "./Sidebar";

const BuyTicketsContainer = () => {

  const [flightData, setFlightData] = useState(null);
  const params = useParams();
  
  const loadFlightData = () => {
    axios.get(`/api/flights/${params.flightId}`, userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK) {
        setFlightData(response.data);
        console.log(response.data);
      }
    }).catch(error => {
      console.log("error");
    });
  }

  useEffect(() => {
    loadFlightData();
  }, []);


    return (
        <>
            <Helmet>
                <title>
                    Buy tickets
                </title>
            </Helmet>

            <Typography variant="h4" component="h1" mt={1}>
                Buy ticket
            </Typography>
            <Grid container>
              <Grid item xs={8}>

              </Grid>
              <Grid item xs={4}>

              </Grid>
            </Grid>
        </>
    );
};

export default BuyTicketsContainer;