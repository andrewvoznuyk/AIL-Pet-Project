import { Breadcrumbs, Button, CardContent, Grid } from "@mui/material";
import React, { useEffect, useState } from "react";
import { Helmet } from "react-helmet-async";
import { useParams } from "react-router-dom";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { responseStatus } from "../../../utils/consts";
import NotFoundPage from "../../../pages/notFound/NotFoundPage";
import PlaneBuilder from "./PlaneBuilder";
import CardTicketInfo from "./CardTicketInfo";
import PopupPayment from "../../elemets/popup/PopupPayment";
import Box from "@mui/material/Box";

const BuyTicketsContainer = () => {

  const [flightData, setFlightData] = useState(null);
  const [boughtTickets, setBoughtTickets] = useState(null);
  const [ticketPricesArray, setTicketPricesArray] = useState(
    {
      business: 50,
      econom: 20,
      standard: 30
    });
  const [totalPrice, setTotalPrice] = useState(0);
  const [selectedPlaces, setSelectedPlaces] = useState([]);
  const [isPaymentPopupOpen, setPaymentPopupOpen] = useState(false);
  const params = useParams();

  /**
   * <DATA LOADING>
   */
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
        console.log(response.data);
      }
    }).catch(error => {
      setBoughtTickets(undefined);
    });
  };
  /**
   * </DATA LOADING>
   */


  const onPlaceClick = (placeData) => {

    placeData.price = ticketPricesArray[placeData.class];
    let index = -1;
    for (let i = 0; i < selectedPlaces.length; i++) {
      if (selectedPlaces[i].place === placeData.place) {
        index = i;
        break;
      }
    }

    if (index !== -1) {
      removePlace(placeData);
    } else {
      addPlace(placeData);
    }
  };

  const addPlace = (placeData) => {
    setSelectedPlaces([...selectedPlaces, placeData]);
  };

  const removePlace = (placeData) => {
    setSelectedPlaces(selectedPlaces.filter((seat) => seat.place !== placeData.place));
  };

  const changeOneTicketItem = (ticketItem) => {
    let index = -1;
    for (let i = 0; i < selectedPlaces.length; i++) {
      if (selectedPlaces[i].place === ticketItem.place) {
        selectedPlaces[i] = ticketItem;
        break;
      }
    }

    setSelectedPlaces(selectedPlaces);
  };

  const onButtonBuyClick = (e) => {
    console.log(selectedPlaces);
    //open modal window
    setPaymentPopupOpen(true);
  };

  const onButtonApprovePurchaseClick = (e) => {
    //TODO: send purchase data
    closePaymentPopup();
  };
  const closePaymentPopup = (e) => {
    setPaymentPopupOpen(false);
  };

  useEffect(() => {
    loadFlightData();
    loadPurchasedTickets();
  }, []);

  //recalculate total price
  useEffect(() => {
    const sum = selectedPlaces.reduce((accumulator, obj) => {
      return accumulator + obj.price;
    }, 0);
    setTotalPrice(sum);
  }, [selectedPlaces]);

  return (
    <>
      <Helmet>
        <title>
          Buy tickets
        </title>
      </Helmet>

      {
        flightData !== undefined && boughtTickets !== undefined ? (
          <>
            <Grid container>
              <Grid
                item
                xs={9}
                spacing={0}
                padding={0}
                margin={0}
                direction="column"
                style={{ display: "flex", alignItems: "center" }}
              >
                {
                  flightData && (
                    <PlaneBuilder
                      aircraftData={flightData.aircraft}
                      selectedPlaces={selectedPlaces}
                      setSelectedPlaces={setSelectedPlaces}
                      soldPlaces={boughtTickets}
                      onPlaceClick={onPlaceClick}
                    />
                  )
                }
              </Grid>
              <Grid item xs={3} padding={0} margin={0} spacing={0}>

                <Box>
                  {selectedPlaces && selectedPlaces.map((item, key) => {
                    return (
                      <div key={key} style={{paddingBottom: 15}}>
                      <CardTicketInfo
                        placeData={item}
                        setSelectedPlaces={setSelectedPlaces}
                        changeOneTicketItem={changeOneTicketItem}
                        ticketPricesArray={ticketPricesArray}
                      />
                      </div>
                    );
                  })}

                  <p></p>
                  {selectedPlaces.length > 0 &&
                    <Button onClick={onButtonBuyClick} variant="contained" fullWidth>Buy ({totalPrice}$)</Button>
                  }
                </Box>
              </Grid>
            </Grid>

            <PopupPayment
              isOpen={isPaymentPopupOpen}
              onAccept={onButtonApprovePurchaseClick}
              handleClose={closePaymentPopup}
            />
          </>
        ) : (
          <NotFoundPage />
        )
      }
    </>
  );
};

export default BuyTicketsContainer;