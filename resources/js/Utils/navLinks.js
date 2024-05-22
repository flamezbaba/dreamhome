import { mdiSquareRoundedOutline } from "@mdi/js";

export const adminNavLinks = [
    // {
    //     title: "Staffs",
    //     icon: mdiSquareRoundedOutline,
    //     mainRoute: "admin.staff",
    //     link: route("admin.staff"),
    // },
    // {
    //     title: "Teams",
    //     icon: mdiSquareRoundedOutline,
    //     mainRoute: "admin.team",
    //     link: route("admin.team"),
    // },
    {
        title: "Properties",
        icon: mdiSquareRoundedOutline,
        mainRoute: "admin.property",
        link: route("admin.property"),
        // subMenu: [
        //     {
        //         title: "Create Shift",
        //         link: route("admin.shift.create"),
        //     },
        //     {
        //         title: "View Shifts",
        //         link: route("admin.shift"),
        //     },
        // ],
    },
    
];
