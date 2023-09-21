import { useContext } from "react";
import Can from "../../components/elemets/can/Can";
import { AppContext } from "../../App";
import {aircrafts} from "../../rbac-consts";
import NotFoundPage from "../notFound/NotFoundPage";
import CabinetDefaultContainer from "../../components/elemets/cabinet/CabinetDefaultContainer";
import ToolbarRoleSwitch from "../../components/elemets/cabinet/toolbars/ToolbarRoleSwitch";
import PlaneSelectForm from "../../components/planeSelect/PlaneSelectForm";
import AircraftsNewContainer from "../../components/aircraftsNew/owner/AircraftsNewContainer";

const AircraftsNewPage = () => {

  return (
    <>
      <CabinetDefaultContainer
        Sidebar={<ToolbarRoleSwitch />}
        Content={<ContentRoleSwitch />}
      />
    </>
  );
};

const ContentRoleSwitch = () => {
  const { user } = useContext(AppContext);

  if (!user) {
    return <NotFoundPage />;
  }

  return (
    <>
      <Can
        role={user.roles}
        perform={aircrafts.OWNER}
        yes={() => <AircraftsNewContainer/>}
      />
    </>
  );
};

export default AircraftsNewPage;