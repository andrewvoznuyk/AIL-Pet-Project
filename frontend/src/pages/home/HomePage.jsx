import {Helmet} from "react-helmet-async";
import {NavLink} from "react-router-dom";
import {Button, ButtonGroup, Typography} from "@mui/material";
import {useContext} from "react";
import {AppContext} from "../../App";
import eventBus from "../../utils/eventBus";
import PlaneSelectForm from "../../components/planeSelect/PlaneSelectForm";
import FlightsContainer from "../../components/searchMainForm/FlightsContainer";

const HomePage = () => {
    const {authenticated} = useContext(AppContext);

    return (
        <div>
            <FlightsContainer/>
        </div>
    );
};

export default HomePage;