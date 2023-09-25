import { Breadcrumbs, Button, CardContent, Grid } from "@mui/material";
import React, { useEffect, useState } from "react";
import { Helmet } from "react-helmet-async";
import { useParams } from "react-router-dom";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { responseStatus } from "../../../utils/consts";
import NotFoundPage from "../../../pages/notFound/NotFoundPage";
import PlaneBuilder from "./PlaneBuilder";

const BuyTicketsContainer = () => {

  const [flightData, setFlightData] = useState(null);
  const [boughtTickets, setBoughtTickets] = useState(null);
  const [selectedPlaces, setSelectedPlaces] = useState([]);
  const params = useParams();

  const loadFlightData = () => {
    axios.get(`/api/flights/${params.flightId}`, userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK) {
        setFlightData(response.data);
      }
    }).catch(error => {
      setFlightData(undefined);
    });
  };

  const loadPurchasedTickets = () => {
    axios.get(`/api/tickets/flight/${params.flightId}`, userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK) {
        setBoughtTickets(response.data);
        console.log(response.data)
      }
    }).catch(error => {
      setFlightData(undefined);
    });
  };

  useEffect(() => {
    loadFlightData();
    loadPurchasedTickets();
  }, []);

  return (
    <>
      <Helmet>
        <title>
          Buy tickets
        </title>
      </Helmet>

      {
        flightData !== undefined ? (
          <>
            <Grid container>
              <Grid
                item
                xs={8}
                spacing={0}
                direction="column"
                style={{display: "flex", alignItems: "center"}}
              >
                {
                  flightData && (
                    <PlaneBuilder
                      aircraftData={flightData.aircraft}
                      selectedPlaces={selectedPlaces}
                      setSelectedPlaces={setSelectedPlaces}
                    />
                  )
                }

              </Grid>
              <Grid item xs={4}>
                <CardContent>

                </CardContent>
              </Grid>
            </Grid>
          </>
        ) : (
          <NotFoundPage />
        )
      }
    </>
  );
};

export default BuyTicketsContainer;