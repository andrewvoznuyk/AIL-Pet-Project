import {Helmet} from "react-helmet-async";
import {NavLink} from "react-router-dom";
import {Button, ButtonGroup, Typography} from "@mui/material";
import {useContext} from "react";
import {AppContext} from "../../App";
import eventBus from "../../utils/eventBus";
import PlaneSelectForm from "../../components/planeSelect/PlaneSelectForm";
import FlightContainer from "../../components/flight/FlightContainer";

const HomePage = () => {
    const {authenticated} = useContext(AppContext);

    return (
        <>
            <Helmet>
                <title>
                    Cabinet
                </title>

                {/* TODO: if manager */}
                <FlightContainer/>
            </Helmet>
        </>
    );
};

export default HomePage;