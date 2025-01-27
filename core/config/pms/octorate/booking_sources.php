<?php

require_once __DIR__ . '/../../../const/booking_sources_const.php';

/**
 * Define all the booking sources in this file which got from the PMS.
 * the Booking source value that will come from PMS write on the left side of the array and the booking source of CAX constant on the right side of the array.
 *
 * Getting all channel list from here [https://octorate.com/en/channel-manager/]
 * [https://api.octorate.com/connect/rest/v1/meta/portals] // postman
 * [https://api.octorate.com/connect/rest/v1/portal?includeDisabled=true&includeHidden=true] // admin
 */

return [
    "270" => DIRECT_RESERVATIONS,
    "277" => BOOKING_123,
    "271" => AGODA,
    "274" => AIRBNB,
    "209" => ALBATRAVEL,
    "312" => ALLIANCE_RESAUX,
    "304" => YESALPS,
    "184" => ALPITOUR_WORLD,
    "25" => ALWAYS_ON_VACATION,
    "385" => AMADEUS,
    "340" => AS_A_GUEST_KOEDIA,
    "226" => ATEL,
    "172" => ATRAPALO,
    "198" => ATRAVEO,
    "368" => AVORIS,
    "336" => BAKUUN,
    "3" => BEDAND_BREAKFAST_IT,
    "10" => BEDAND_BREAKFAST_COM,
    "279" => BEDANDBREAKFAST_EU,
    "327" => BEDANDBREAKFAST_NL,
    "181" => BEDANDBREAKFASTROMA,
    "203" => BEDYCASA_ONLY_AVAILABILITY,
    "306" => BESTDAY,
    "353" => BESTHOLIDAYS_NETSTORMING,
    "346" => BLUE_PILLOW,
    "195" => BOOKINGAY,
    "289" => BOOKINGFOR,
    "2" => BOOKING_DOT_COM,
    "142" => BOOKING_DOT_COM,
    "191" => BOOK_ON,
    "250" => BOOKONLINENOW,
    "321" => BOOKVISIT,
    "383" => BRAINY,
    "220" => CAMPINGITALIA,
    "455" => CASAS_RURALES_NET,
    "348" => CHANNEX,
    "273" => CHARMINGITALY_NEW,
    "303" => CHIC_RETREATS,
    "320" => CISALPINA,
    "284" => CITYZENBOOKING,
    "152" => CLICK_BEDS,
    "245" => CTRIP,
    "302" => CUSTOMER_ALLIANCE,
    "297" => DAY_BREAK_HOTELS,
    "357" => D_EDGE,
    "278" => DELPHINET,
    "255" => DESPEGAR_XML,
    "293" => DESTINATION_FLORENCE,
    "246" => DISCOVEROOM,
    "310" => DJOCA,
    "391" => DOLOMITI_IT_DESTINATION_SRI,
    "256" => DORMS,
    "24" => EASY_TO_BOOK,
    "373" => ELLOHA,
    "187" => ESCAPIO,
    "314" => MON_SEJOUR_EN_MONTAGNE,
    "4" => EXPEDIA,
    "257" => FERATEL,
    "339" => TRAUM_FERIENWOHNUNGEN_DE,
    "222" => FISHEYES_XML,
    "379" => FLEXHOTEL_THE_BOOKING_ENGINE,
    "386" => FREEGOO,
    "196" => GARDAPASS_FEDER_ALBERGHI,
    "317" => DRIVE_SPREADSHEET_SYNCH,
    "219" => GITES_DE_FRANCE,
    "193" => GLOBEKEY,
    "151" => GOMIO,
    "22" => GOOGLE_CAL,
    "328" => GREEEN_SOFT,
    "206" => GTA,
    "163" => HIHOSTELS,
    "331" => HIPORESA,
    "224" => HOLIDAYLETTINGS_ONLY_AVAILABILITY,
    "254" => HOLIDAYLETTINGS_FLIPKEY_HOUSETRIP,
    "333" => HOLIDU,
    "235" => VRBO_HOME_AWAY,
    "369" => HOME_TO_GO,
    "381" => HOPPER,
    "7" => HOSTELS_CLUB,
    "179" => HOSTELS_COM,
    "157" => HOSTELWORLD,
    "28" => HOTELBEDS,
    "298" => HOTELBONANZA,
    "5" => HOTEL_DE,
    "194" => EASY_CONSULTING,
    "190" => HOTELIERS,
    "323" => HOTELNET,
    "240" => HOTEL_ONLINE_FR,
    "164" => HOTELS_COM,
    "227" => HOTELCLICK,
    "285" => HOTELSCORSE,
    "299" => HOTELSPECIALS_NL,
    "316" => HOTELTONIGHT,
    "178" => HOTELTRAVEL,
    "214" => HOTELS_COMBINED_REVATO,
    "211" => HOTEL_INN,
    "180" => HOTEL_NL,
    "175" => KEYTEL_HOTUSA,
    "192" => HRS,
    "367" => HYPERGUEST,
    "221" => ICASTELLI,
    "275" => I_CLOUD,
    "238" => IMPERATORE_OPENTUR,
    "329" => IMPERATORE_TRAVEL_WORLD_NETSTORMING,
    "372" => IMPERATORE_I_VECTOR,
    "292" => IN_ITALIA_DK,
    "210" => INHORES,
    "49" => INSTANT_WORLD_BOOKING,
    "341" => INTERRIAS,
    "218" => ITALCAMEL,
    "334" => ITALYHOTELS,
    "335" => IVH_TRAVEL,
    "378" => IXPIRA,
    "189" => JUMBO,
    "324" => JUNIPER,
    "16" => LASTMINUTE_COM,
    "14" => LATEROOMS,
    "344" => LOVE_VDA,
    "258" => MAKEMYTRIP,
    "380" => MARRIOTT_HOMES_AND_VILLAS,
    "237" => METGLOBAL,
    "290" => MIRAI,
    "150" => MRAND_MRS_SMITH,
    "359" => MYITALYSELECTION,
    "216" => NATURAL_BOOKING,
    "377" => NEWHOTELSOFTWARE,
    "384" => NICE_HOSPITALITY,
    "38" => FLATS_ONLY_AVAILABILITY_9,
    "236" => NIUMBA,
    "325" => OCTOCHANNEL,
    "233" => OCTORATE,
    "291" => ODIGEO_CONNECT,
    "66" => OH_BARCELONA,
    "215" => OKTOGO,
    "207" => OMEGA_HOTELS,
    "358" => ONEUPTRAVEL,
    "281" => ONLYAPARTMENTS_XML,
    "17" => ORBITZ,
    "201" => OSTROVOK,
    "318" => OTHYSSIA,
    "276" => OUTLOOK,
    "332" => PLUMGUIDE,
    "154" => PRESTIGIA,
    "356" => RAKUTEN_TRAVEL_XCHANGE,
    "456" => RATEBOTAI,
    "208" => RECOLINE,
    "176" => RENTALS_UNITED,
    "322" => LOGIS,
    "177" => RIAD_FR,
    "365" => ROOMMATIK,
    "21" => ROOMORAMA__ONLY_AVAILABILITY,
    "313" => RYANAIR,
    "185" => SABRE_HOLDINGS,
    "374" => SALTO,
    "153" => SEJOURING,
    "229" => SHAREBOOKING,
    "231" => SIMPLEBOOKING,
    "296" => SIREONTOURS,
    "295" => BOOKING_EXPERT,
    "212" => SLEEPING_ROME,
    "315" => SMARTBOX,
    "280" => SMARTMEMBER,
    "308" => SPECIAL_TOURS,
    "54" => SPLENDIA,
    "244" => SUNHOTELS,
    "173" => SUPER_BED,
    "234" => TABLET,
    "287" => TABLETHOTELS_XML,
    "337" => TITANKA_MR_PRENO,
    "23" => TOBOOK,
    "251" => TOURICOHOLIDAYS,
    "162" => TRAVELOCITY,
    "213" => TRANSHOTEL,
    "241" => TRAVCO,
    "309" => TRAVELCLICK,
    "6" => TRAVEL_EUROPE,
    "366" => TRAVELGATE_X,
    "174" => TRAVELLEDIA,
    "330" => TRAVELOKA,
    "182" => TRAVEL_REPUBLIC,
    "354" => TRAVELSTAY,
    "351" => TRAVELONTIME,
    "301" => TRIP_RENTAL,
    "42" => ULTRANET,
    "36" => UNITRAVEL,
    "294" => VERTICAL_BOOKING,
    "371" => VESUVIO_TOUR,
    "29" => VIAGGIARE_WEB_ONLY_AVAILABILITY,
    "400" => VIAJESPARATI,
    "230" => VIVAFIRENZE_IT,
    "272" => WEBBOOKING,
    "259" => WEBDESGIN,
    "286" => WEEKENDESK,
    "249" => WELCOMEBEDS,
    "326" => WE_SUITE,
    "370" => WHATSAPP_MESSAGE_BIRD,
    "225" => WHL,
    "161" => WIMDU_ONLY_AVAILABILITIES,
    "11" => WOTIF,
    "282" => XENIA,
    "165" => YOURSPAINHOSTEL,
    "168" => ZUJI
];