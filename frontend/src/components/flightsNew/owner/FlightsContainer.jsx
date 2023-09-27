import React from "react";
import { Helmet } from "react-helmet-async";
import { Breadcrumbs, Link, Typography } from "@mui/material";
import { NavLink } from "react-router-dom";
import FlightsCreate from "./FlightsCreate";

const FlightsContainer = () => {
  return (
    <>
      <Helmet>
        <title>
          Flights
        </title>
      </Helmet>
      <Breadcrumbs aria-label="breadcrumb">
        <Link component={NavLink} underline="hover" color="inherit" to="/">
          Home
        </Link>
        <Typography color="text.primary">Flights</Typography>
      </Breadcrumbs>
      <Typography variant="h4" component="h1" mt={1} mb={2}>
        Flights
      </Typography>
      <FlightsCreate />
    </>
  );
};

export default FlightsContainer;