import { Breadcrumbs, Button, CardContent, Grid } from "@mui/material";
import React, { useEffect, useState } from "react";
import { Helmet } from "react-helmet-async";
import { useNavigate, useParams } from "react-router-dom";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { responseStatus } from "../../../utils/consts";
import NotFoundPage from "../../../pages/notFound/NotFoundPage";
import PlaneBuilder from "./PlaneBuilder";
import CardTicketInfo from "./CardTicketInfo";
import PopupPayment from "../../elemets/popup/PopupPayment";
import Box from "@mui/material/Box";
import Notification from "../../elemets/notification/Notification";

const BuyTicketsContainer = () => {

  const navigate = useNavigate();

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

  const [loading, setLoading] = useState(false);
  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

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
  const loadTicketsPriceData = () => {
    axios.get(`/api/tickets/prices/${params.flightId}`, userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK) {
        setTicketPricesArray(response.data);
      }
    }).catch(error => {
    });
  };

  const loadPurchasedTickets = () => {
    axios.get(`/api/tickets/flight/${params.flightId}`, userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK) {
        setBoughtTickets(response.data);
      }
    }).catch(error => {
      setBoughtTickets([]);
    });
  };
  /**
   * </DATA LOADING>
   */


  const reloadPage = () => {
    navigate(0);
  };

  const onPlaceClick = (placeData) => {
    placeData.price = ticketPricesArray[placeData.class];
    placeData.flight = params.flightId;

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
    //open modal window
    setPaymentPopupOpen(true);
  };

  const onButtonApprovePurchaseClick = (e) => {

    setLoading(true);
    axios.post(`/api/tickets/purchase`, selectedPlaces, userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_CREATED) {
        setNotification({
          ...notification,
          visible: true,
          type: "success",
          message: "Tickets successfully purchased!"
        });
        reloadPage();
      }
    }).catch(error => {

      if (error.response.status === responseStatus.HTTP_ERROR_VALIDATION) {
        setNotification({ ...notification, visible: true, type: "error", message: "Fill all blank fields" });
      } else {
        setNotification({ ...notification, visible: true, type: "error", message: error.response.data.message });
      }
    }).finally(() => {
      setLoading(false);
      closePaymentPopup();

    });
  };

  const closePaymentPopup = (e) => {
    setPaymentPopupOpen(false);
  };

  //load all required data
  useEffect(() => {
    loadFlightData();
    loadPurchasedTickets();
    loadTicketsPriceData();
  }, []);

  //recalculate total price on place select
  useEffect(() => {
    const sum = selectedPlaces.reduce((accumulator, obj) => {
      return accumulator + obj.price;
    }, 0);
    setTotalPrice(sum);
  }, [selectedPlaces]);

  return (
    <>
      {notification.visible &&
        <Notification
          notification={notification}
          setNotification={setNotification}
        />
      }

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
                      <div key={key} style={{ paddingBottom: 15 }}>
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
                    <Button
                      onClick={onButtonBuyClick}
                      variant="contained"
                      fullWidth
                    >
                      Buy ({totalPrice}$)
                    </Button>
                  }
                </Box>
              </Grid>
            </Grid>

            <PopupPayment
              isOpen={isPaymentPopupOpen}
              onAccept={onButtonApprovePurchaseClick}
              handleClose={closePaymentPopup}
              loading={loading}
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