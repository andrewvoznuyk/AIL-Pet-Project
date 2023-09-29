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

      <Typography variant="h4" component="h1" mt={1} mb={2}>
        Flights
      </Typography>
      <FlightsCreate />
    </>
  );
};

export default FlightsContainer;