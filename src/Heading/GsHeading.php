<?php

namespace Gtlogistics\X12Parser\Heading;


use Gtlogistics\X12Parser\Model\AbstractSegment;
use Gtlogistics\X12Parser\Model\TransactionSetInterface;

/**
 * @property "AA"|"AB"|"AC"|"AD"|"AE"|"AF"|"AG"|"AH"|"AI"|"AK"|"AL"|"AM"|"AN"|"AO"|"AP"|"AQ"|"AR"|"AS"|"AT"|"AU"|"AV"|"AW"|"AX"|"AY"|"AZ"|"BA"|"BB"|"BC"|"BD"|"BE"|"BF"|"BG"|"BL"|"BS"|"CA"|"CB"|"CC"|"CD"|"CE"|"CF"|"CH"|"CI"|"CJ"|"CK"|"CL"|"CM"|"CN"|"CO"|"CP"|"CQ"|"CR"|"CS"|"CT"|"CU"|"CV"|"CW"|"D3"|"D4"|"D5"|"DA"|"DD"|"DF"|"DI"|"DM"|"DS"|"DX"|"EC"|"ED"|"EI"|"EN"|"EO"|"EP"|"ER"|"ES"|"EV"|"EX"|"FA"|"FB"|"FC"|"FG"|"FR"|"FT"|"GC"|"GE"|"GF"|"GL"|"GP"|"GR"|"GT"|"HB"|"HC"|"HI"|"HN"|"HP"|"HR"|"HS"|"HU"|"HV"|"IA"|"IB"|"IC"|"ID"|"IE"|"IF"|"IG"|"IH"|"IJ"|"IM"|"IN"|"IO"|"IR"|"IS"|"JB"|"KM"|"LA"|"LB"|"LI"|"LN"|"LR"|"LS"|"LT"|"MA"|"MC"|"MD"|"ME"|"MF"|"MG"|"MH"|"MI"|"MJ"|"MK"|"MM"|"MN"|"MO"|"MP"|"MQ"|"MR"|"MS"|"MT"|"MV"|"MW"|"MX"|"MY"|"MZ"|"NC"|"NL"|"NP"|"NR"|"NT"|"OC"|"OG"|"OR"|"OW"|"PA"|"PB"|"PC"|"PD"|"PE"|"PF"|"PG"|"PH"|"PI"|"PJ"|"PK"|"PL"|"PN"|"PO"|"PQ"|"PR"|"PS"|"PT"|"PU"|"PV"|"PW"|"PY"|"QG"|"QM"|"QO"|"RA"|"RB"|"RC"|"RD"|"RE"|"RF"|"RG"|"RH"|"RI"|"RJ"|"RK"|"RL"|"RM"|"RN"|"RO"|"RP"|"RQ"|"RR"|"RS"|"RT"|"RU"|"RV"|"RW"|"RX"|"RY"|"RZ"|"SA"|"SB"|"SC"|"SD"|"SE"|"SF"|"SH"|"SI"|"SJ"|"SL"|"SM"|"SN"|"SO"|"SP"|"SQ"|"SR"|"SS"|"ST"|"SU"|"SV"|"SW"|"TA"|"TB"|"TD"|"TE"|"TF"|"TI"|"TJ"|"TM"|"TN"|"TO"|"TP"|"TR"|"TT"|"TU"|"TX"|"UA"|"UB"|"UC"|"UD"|"UI"|"UP"|"UW"|"VA"|"VB"|"VC"|"VD"|"VE"|"VH"|"VI"|"VS"|"WA"|"WB"|"WG"|"WI"|"WL"|"WR"|"WT" $_01 **Functional Identifier Code:** Code identifying a group of application related transaction sets
 * - AA: Account Analysis (822)
 * - AB: Logistics Service Request (219)
 * - AC: Associated Data (102)
 * - AD: Individual Life, Annuity and Disability Application (267)
 * - AE: Premium Audit Request and Return (187)
 * - AF: Application for Admission to Educational Institutions (189)
 * - AG: Application Advice (824)
 * - AH: Logistics Service Response (220)
 * - AI: Automotive Inspection Detail (928)
 * - AK: Student Educational Record (Transcript) Acknowledgment (131)
 * - AL: Set Cancellation (998)
 * - AM: Item Information Request (893)
 * - AN: Return Merchandise Authorization and Notification (180)
 * - AO: Income or Asset Offset (521)
 * - AP: Abandoned Property Filings (103)
 * - AQ: Customs Manifest (309)
 * - AR: Warehouse Stock Transfer Shipment Advice (943)
 * - AS: Transportation Appointment Schedule Information (163)
 * - AT: Animal Toxicological Data (249)
 * - AU: Customs Status Information (350)
 * - AV: Customs Carrier General Order Status (352)
 * - AW: Warehouse Inventory Adjustment Advice (947)
 * - AX: Customs Events Advisory Details (353)
 * - AY: Customs Automated Manifest Archive Status (354)
 * - AZ: Customs Acceptance/Rejection (355)
 * - BA: Customs Permit to Transfer Request (356)
 * - BB: Customs In-Bond Information (357)
 * - BC: Business Credit Report (155)
 * - BD: Customs Consist Information (358)
 * - BE: Benefit Enrollment and Maintenance (834)
 * - BF: Business Entity Filings (105)
 * - BG: Customs Customer Profile Management (359)
 * - BL: Motor Carrier Bill of Lading (211)
 * - BS: Shipment and Billing Notice (857)
 * - CA: Purchase Order Change Acknowledgment/Request - Seller Initiated (865)
 * - CB: Unemployment Insurance Tax Claim or Charge Information (153)
 * - CC: Clauses and Provisions (504)
 * - CD: Credit/Debit Adjustment (812)
 * - CE: Cartage Work Assignment (222)
 * - CF: Corporate Financial Adjustment Information (844 and 849)
 * - CH: Car Handling Information (420)
 * - CI: Consolidated Service Invoice/Statement (811)
 * - CJ: Manufacturer Coupon Family Code Structure (877)
 * - CK: Manufacturer Coupon Redemption Detail (881)
 * - CL: Election Campaign and Lobbyist Reporting (113)
 * - CM: Component Parts Content (871)
 * - CN: Coupon Notification (887)
 * - CO: Cooperative Advertising Agreements (290)
 * - CP: Electronic Proposal Information (251, 805)
 * - CQ: Commodity Movement Services Response (874)
 * - CR: Rail Carhire Settlements (414)
 * - CS: Cryptographic Service Message (815)
 * - CT: Application Control Totals (831)
 * - CU: Commodity Movement Services (873)
 * - CV: Commercial Vehicle Safety and Credentials Information Exchange (285)
 * - CW: Educational Institution Record (133)
 * - D3: Contract Completion Status (567)
 * - D4: Contract Abstract (561, 890)
 * - D5: Contract Payment Management Report (568)
 * - DA: Debit Authorization (828)
 * - DD: Shipment Delivery Discrepancy Information (854)
 * - DF: Market Development Fund Allocation (883)
 * - DI: Dealer Information (128)
 * - DM: Equipment Order (422)
 * - DS: Data Status Tracking (242)
 * - DX: Direct Exchange Delivery and Return Information (894, 895)
 * - EC: Educational Course Inventory (188)
 * - ED: Student Educational Record (Transcript) (130)
 * - EI: Railroad Equipment Inquiry or Advice (456)
 * - EN: Equipment Inspection (228)
 * - EO: Transportation Equipment Registration (603)
 * - EP: Environmental Compliance Reporting (179)
 * - ER: Revenue Receipts Statement (170)
 * - ES: Notice of Employment Status (540)
 * - EV: Railroad Event Report (451)
 * - EX: Excavation Communication (620)
 * - FA: Functional or Implementation Acknowledgment Transaction Sets (997, 999)
 * - FB: Freight Invoice (859)
 * - FC: Court and Law Enforcement Information (175, 176)
 * - FG: Motor Carrier Loading and Route Guide (217)
 * - FR: Financial Reporting (821, 827)
 * - FT: File Transfer (996)
 * - GC: Damage Claim Transaction Sets (920, 924, 925, 926)
 * - GE: General Request, Response or Confirmation (814)
 * - GF: Response to a Load Tender (990)
 * - GL: Intermodal Group Loading Plan (715)
 * - GP: Grocery Products Invoice (880)
 * - GR: Statistical Government Information (152)
 * - GT: Grant or Assistance Application (194)
 * - HB: Eligibility, Coverage or Benefit Information (271)
 * - HC: Health Care Claim (837)
 * - HI: Health Care Services Review Information (278)
 * - HN: Health Care Information Status Notification (277)
 * - HP: Health Care Claim Payment/Advice (835)
 * - HR: Health Care Claim Status Request (276)
 * - HS: Eligibility, Coverage or Benefit Inquiry (270)
 * - HU: Human Resource Information (132)
 * - HV: Health Care Benefit Coordination Verification (269)
 * - IA: Air Freight Details and Invoice (110, 980)
 * - IB: Inventory Inquiry/Advice (846)
 * - IC: Rail Advance Interchange Consist (418)
 * - ID: Insurance/Annuity Application Status (273)
 * - IE: Insurance Producer Administration (252)
 * - IF: Individual Insurance Policy and Client Information (111)
 * - IG: Direct Store Delivery Summary Information (882)
 * - IH: Commercial Vehicle Safety Reports (284)
 * - IJ: Report of Injury, Illness or Incident (148)
 * - IM: Motor Carrier Freight Details and Invoice (210, 980)
 * - IN: Invoice Information (810)
 * - IO: Ocean Shipment Billing Details (310, 312, 980)
 * - IR: Rail Carrier Freight Details and Invoice (410, 980)
 * - IS: Estimated Time of Arrival and Car Scheduling (421)
 * - JB: Joint Interest Billing and Operating Expense Statement (819)
 * - KM: Commercial Vehicle Credentials (286)
 * - LA: Federal Communications Commission (FCC) License Application (195)
 * - LB: Lockbox (823)
 * - LI: Locomotive Information (436)
 * - LN: Property and Casualty Loss Notification (272)
 * - LR: Logistics Reassignment (536)
 * - LS: Asset Schedule (851)
 * - LT: Student Loan Transfer and Status Verification (144)
 * - MA: Motor Carrier Summary Freight Bill Manifest (224)
 * - MC: Request for Motor Carrier Rate Proposal (107)
 * - MD: Department of Defense Inventory Management (527)
 * - ME: Mortgage Origination (198, 200, 201, 245, 261, 262, 263, 833, 872)
 * - MF: Market Development Fund Settlement (884)
 * - MG: Mortgage Servicing Transaction Sets (203, 206, 259, 260, 264, 266)
 * - MH: Motor Carrier Rate Proposal (106)
 * - MI: Motor Carrier Shipment Status Inquiry (213)
 * - MJ: Secondary Mortgage Market Loan Delivery (202)
 * - MK: Response to a Motor Carrier Rate Proposal (108)
 * - MM: Medical Event Reporting (500)
 * - MN: Mortgage Note (205)
 * - MO: Maintenance Service Order (650)
 * - MP: Motion Picture Booking Confirmation (159)
 * - MQ: Consolidators Freight Bill and Invoice (223)
 * - MR: Multilevel Railcar Load Details (125)
 * - MS: Material Safety Data Sheet (848)
 * - MT: Electronic Form Structure (868)
 * - MV: Material Obligation Validation (517)
 * - MW: Rail Waybill Response (427)
 * - MX: Material Claim (847)
 * - MY: Response to a Cartage Work Assignment (225)
 * - MZ: Motor Carrier Package Status (240)
 * - NC: Nonconformance Report (842)
 * - NL: Name and Address Lists (101)
 * - NP: Notice of Power of Attorney (157)
 * - NR: Secured Receipt or Acknowledgment (993)
 * - NT: Notice of Tax Adjustment or Assessment (149)
 * - OC: Cargo Insurance Advice of Shipment (362)
 * - OG: Order Group - Grocery (875, 876)
 * - OR: Organizational Relationships (816)
 * - OW: Warehouse Shipping Order (940)
 * - PA: Price Authorization Acknowledgment/Status (845)
 * - PB: Railroad Parameter Trace Registration (455)
 * - PC: Purchase Order Change Request - Buyer Initiated (860)
 * - PD: Product Activity Data (852)
 * - PE: Periodic Compensation (256)
 * - PF: Annuity Activity (268)
 * - PG: Insurance Plan Description (100)
 * - PH: Pricing History (503)
 * - PI: Patient Information (275)
 * - PJ: Project Schedule Reporting (806)
 * - PK: Project Cost Reporting (839) and Contractor Cost Data Reporting (196)
 * - PL: Railroad Problem Log Inquiry or Advice (452)
 * - PN: Product Source Information (244)
 * - PO: Purchase Order (850)
 * - PQ: Property Damage Report (112)
 * - PR: Purchase Order Acknowledgment (855)
 * - PS: Planning Schedule with Release Capability (830)
 * - PT: Product Transfer and Resale Report (867)
 * - PU: Motor Carrier Shipment Pickup Notification (216)
 * - PV: Purchase Order Shipment Management Document (250)
 * - PW: Healthcare Provider Information (274)
 * - PY: Payment Cancellation Request (829)
 * - QG: Product Information (878, 879, 888, 889, 896)
 * - QM: Transportation Carrier Shipment Status Message (214)
 * - QO: Ocean Shipment Status Information (313, 315)
 * - RA: Payment Order/Remittance Advice (820)
 * - RB: Railroad Clearance (470)
 * - RC: Receiving Advice/Acceptance Certificate (861)
 * - RD: Royalty Regulatory Report (185)
 * - RE: Warehouse Stock Receipt Advice (944)
 * - RF: Request for Routing Instructions (753)
 * - RG: Routing Instructions (754)
 * - RH: Railroad Reciprocal Switch File (433)
 * - RI: Routing and Carrier Instruction (853)
 * - RJ: Railroad Mark Register Update Activity (434)
 * - RK: Standard Transportation Commodity Code Master (435)
 * - RL: Rail Industrial Switch List (423)
 * - RM: Railroad Station Master File (431)
 * - RN: Requisition Transaction (511)
 * - RO: Ocean Booking Information (300, 301, 303)
 * - RP: Commission Sales Report (818)
 * - RQ: Request for Quotation (840) and Procurement Notices (836)
 * - RR: Response to Request For Quotation (843)
 * - RS: Order Status Information (869, 870)
 * - RT: Report of Test Results (863)
 * - RU: Railroad Retirement Activity (429)
 * - RV: Railroad Junctions and Interchanges Activity (437)
 * - RW: Rail Revenue Waybill (426)
 * - RX: Rail Car Hire Rate Negotiation
 * - RY: Request for Student Educational Record (Transcript) (146)
 * - RZ: Response to Request for Student Educational Record (Transcript) (147)
 * - SA: Air Shipment Information (104)
 * - SB: Rail Carrier Services Settlement (424)
 * - SC: Price/Sales Catalog (832, 897)
 * - SD: Student Loan Pre-Claims and Claims (191)
 * - SE: Shipper's Export Declaration (601)
 * - SF: Customs Manifest (309)
 * - SH: Ship Notice/Manifest (856)
 * - SI: Shipment Information (858)
 * - SJ: Transportation Automatic Equipment Identification (160)
 * - SL: Student Aid Origination Record (135, 139)
 * - SM: Motor Carrier Load Tender (204)
 * - SN: Rail Route File Maintenance (475)
 * - SO: Ocean Shipment Information (304, 311, 317, 319, 322, 323, 324, 325, 326, 361)
 * - SP: Specifications/Technical Information (841)
 * - SQ: Production Sequence (866)
 * - SR: Rail Carrier Shipment Information (404, 419)
 * - SS: Shipping Schedule (862)
 * - ST: Railroad Service Commitment Advice (453)
 * - SU: Account Assignment/Inquiry and Service/Status (248)
 * - SV: Student Enrollment Verification (190)
 * - SW: Warehouse Shipping Advice (945)
 * - TA: Electronic Filing of Tax Return Data Acknowledgment (151)
 * - TB: Trailer or Container Repair Billing (412)
 * - TD: Trading Partner Profile (838)
 * - TE: Tax or Fee Exemption Certification (283)
 * - TF: Electronic Filing of Tax Return Data (813)
 * - TI: Tax Information Exchange (826)
 * - TJ: Tax Jurisdiction Sourcing (158)
 * - TM: Motor Carrier Delivery Trailer Manifest (212)
 * - TN: Tax Rate Notification (150)
 * - TO: Real Estate Title Services (197, 199, 265, 485, 486)
 * - TP: Rail Rate Transactions (460, 463, 466, 468, 485, 486, 490, 492, 494)
 * - TR: Train Sheet (161)
 * - TT: Educational Testing and Prospect Request and Report (138)
 * - TU: Trailer Usage Report (227)
 * - TX: Text Message (864)
 * - UA: Retail Account Characteristics (885)
 * - UB: Customer Call Reporting (886)
 * - UC: Secured Interest Filing (154)
 * - UD: Deduction Research Report (891)
 * - UI: Underwriting Information Services (255)
 * - UP: Motor Carrier Pickup Manifest (215)
 * - UW: Insurance Underwriting Requirements Reporting (186)
 * - VA: Vehicle Application Advice (126)
 * - VB: Vehicle Baying Order (127)
 * - VC: Vehicle Shipping Order (120)
 * - VD: Vehicle Damage (124)
 * - VE: Vessel Content Details (109)
 * - VH: Vehicle Carrier Rate Update (129)
 * - VI: Voter Registration Information (280)
 * - VS: Vehicle Service (121)
 * - WA: Product Service Transaction Sets (140, 141, 142, 143)
 * - WB: Rail Carrier Waybill Interchange (417)
 * - WG: Vendor Performance Review (501, 892)
 * - WI: Wage Determination (288)
 * - WL: Well Information (625)
 * - WR: Shipment Weights (440)
 * - WT: Rail Waybill Request (425)
 * @property string $_02 **Application Sender's Code:** Code identifying party sending transmission; codes agreed to by trading partners
 * @property string $_03 **Application Receiver's Code:** Code identifying party receiving transmission; codes agreed to by trading partners
 * @property \DateTimeInterface $_04 **Date:** Date expressed as CCYYMMDD where CC represents the first two digits of the calendar year
 * @property \DateTimeInterface $_05 **Time:** Time expressed in 24-hour clock time as follows: HHMM, or HHMMSS, or HHMMSSD, or HHMMSSDD, where H = hours (00-23), M = minutes (00-59), S = integer seconds (00-59) and DD = decimal seconds; decimal seconds are expressed as follows: D = tenths (0-9) and DD = hundredths (00-99)
 * @property string $_06 **Group Control Number:** Assigned number originated and maintained by the sender
 * @property "T"|"X" $_07 **Responsible Agency Code:** Code identifying the issuer of the standard; this code is used in conjunction with Data Element 480
 * - T: Transportation Data Coordinating Committee (TDCC)
 * - X: Accredited Standards Committee X12
 * @property "001000"|"002000"|"002001"|"002002"|"002003"|"002031"|"002040"|"002041"|"002042"|"003000"|"003010"|"003011"|"003012"|"003020"|"003021"|"003022"|"003030"|"003031"|"003032"|"003040"|"003041"|"003042"|"003050"|"003051"|"003052"|"003060"|"003061"|"003062"|"003070"|"003071"|"003072"|"004000"|"004010"|"004011"|"004012"|"004020"|"004021"|"004022"|"004030"|"004031"|"004032"|"004040"|"004041"|"004042"|"004050"|"004051"|"004052"|"004060"|"004061"|"004062"|"005000"|"005010"|"005011"|"005012"|"005020"|"005021"|"005022"|"005030"|"005031"|"005032"|"005040"|"005041"|"005042"|"005050"|"005051"|"005052"|"006000"|"006010"|"006011"|"006012"|"006020"|"006021"|"006022"|"006030"|"006031"|"006032"|"006040"|"006041"|"006042"|"006050"|"006051"|"006052"|"007000"|"007010"|"007011"|"007012"|"007020"|"007021"|"007022"|"007030"|"007031"|"007032"|"007040"|"007041"|"007042"|"007050"|"007051"|"007052"|"007060"|"007061"|"007062"|"008000"|"008010"|"008020"|"008030"|"008040"|"008050" $_08 **Version / Release / Industry Identifier Code:** Code indicating the version, release, and industry identifier of the EDI Standard being used, including the GS and GE segments; if the code in DE455 in the GS segment is X, then DE 480 positions 1-3 are the version number; positions 4-6 are the release level of the version; and positions 7-12 are the industry or trade association identifiers (optionally assigned by user); if the code in DE455 in the GS segment is T, other formats are allowed.
 * - 001000: ASC X12 Standards Approved by ANSI in 1983
 * - 002000: ASC X12 Standards Approved by ANSI in 1986
 * - 002001: Draft Standards Approved by ASC X12 in November 1987
 * - 002002: Draft Standards Approved by ASC X12 through February 1988
 * - 002003: Draft Standards Approved by ASC X12 through August 1988
 * - 002031: Draft Standards Approved by ASC X12 through February 1989
 * - 002040: Draft Standards Approved by ASC X12 through May 1989
 * - 002041: Draft Standards Approved by ASC X12 through October 1989
 * - 002042: Draft Standards Approved by ASC X12 through February 1990
 * - 003000: ASC X12 Standards Approved by ANSI in 1992
 * - 003010: Draft Standards Approved by ASC X12 through June 1990
 * - 003011: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through February 1991
 * - 003012: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through June 1991
 * - 003020: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through October 1991
 * - 003021: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through February 1992
 * - 003022: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through June 1992
 * - 003030: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through October 1992
 * - 003031: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through February 1993
 * - 003032: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through June 1993
 * - 003040: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through October 1993
 * - 003041: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through February 1994
 * - 003042: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through June 1994
 * - 003050: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through October 1994
 * - 003051: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through February 1995
 * - 003052: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through June 1995
 * - 003060: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through October 1995
 * - 003061: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through February 1996
 * - 003062: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through June 1996
 * - 003070: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through October 1996
 * - 003071: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through February 1997
 * - 003072: Draft Standards Approved for Publication by ASC X12 Procedures Review Board through June 1997
 * - 004000: ASC X12 Standards Approved by ANSI in 1997
 * - 004010: Standards Approved for Publication by ASC X12 Procedures Review Board through October 1997
 * - 004011: Standards Approved for Publication by ASC X12 Procedures Review Board through February 1998
 * - 004012: Standards Approved for Publication by ASC X12 Procedures Review Board through June 1998
 * - 004020: Standards Approved for Publication by ASC X12 Procedures Review Board through October 1998
 * - 004021: Standards Approved for Publication by ASC X12 Procedures Review Board through February 1999
 * - 004022: Standards Approved for Publication by ASC X12 Procedures Review Board through June 1999
 * - 004030: Standards Approved for Publication by ASC X12 Procedures Review Board through October 1999
 * - 004031: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2000
 * - 004032: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2000
 * - 004040: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2000
 * - 004041: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2001
 * - 004042: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2001
 * - 004050: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2001
 * - 004051: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2002
 * - 004052: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2002
 * - 004060: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2002
 * - 004061: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2003
 * - 004062: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2003
 * - 005000: ASC X12 Standards Approved by ANSI in 2003
 * - 005010: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2003
 * - 005011: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2004
 * - 005012: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2004
 * - 005020: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2004
 * - 005021: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2005
 * - 005022: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2005
 * - 005030: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2005
 * - 005031: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2006
 * - 005032: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2006
 * - 005040: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2006
 * - 005041: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2007
 * - 005042: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2007
 * - 005050: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2007
 * - 005051: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2008
 * - 005052: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2008
 * - 006000: ASC X12 Standards Approved by ANSI in 2008
 * - 006010: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2008
 * - 006011: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2009
 * - 006012: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2009
 * - 006020: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2009
 * - 006021: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2010
 * - 006022: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2010
 * - 006030: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2010
 * - 006031: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2011
 * - 006032: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2011
 * - 006040: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2011
 * - 006041: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2012
 * - 006042: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2012
 * - 006050: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2012
 * - 006051: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2013
 * - 006052: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2013
 * - 007000: ASC X12 Standards Approved by ANSI in 2013
 * - 007010: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2013
 * - 007011: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2014
 * - 007012: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2014
 * - 007020: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2014
 * - 007021: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2015
 * - 007022: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2015
 * - 007030: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2015
 * - 007031: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2016
 * - 007032: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2016
 * - 007040: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2016
 * - 007041: Standards Approved for Publication by ASC X12 Procedures Review Board through February 2017
 * - 007042: Standards Approved for Publication by ASC X12 Procedures Review Board through June 2017
 * - 007050: Standards Approved for Publication by ASC X12 Procedures Review Board through December 2017
 * - 007051: Standards Approved for Publication by ASC X12 Procedures Review Board through April 2018
 * - 007052: Standards Approved for Publication by ASC X12 Procedures Review Board through August 2018
 * - 007060: Standards Approved for Publication by ASC X12 Procedures Review Board through December 2018
 * - 007061: 007061 Standards Approved for Publication by ASC X12 Procedures Review Board through April 2019
 * - 007062: 007062 Standards Approved for Publication by ASC X12 Procedures Review Board through August 2019
 * - 008000: ASC X12 Standards Approved by ANSI in 2019
 * - 008010: 008010 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2019
 * - 008020: 008020 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2020
 * - 008030: 008030 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2021
 * - 008040: 008040 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2022
 * - 008050: 008050 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2023
 */
final class GsHeading extends AbstractSegment
{
    protected array $castings = [
        '_04' => 'date',
        '_05' => 'time',
    ];

    protected array $lengths = [
        '_02' => [2, 15],
        '_03' => [2, 15],
        '_04' => [8, 8],
        '_05' => [4, 8],
        '_06' => [1, 9],
    ];

    protected array $required = [
        '_01' => true,
        '_02' => true,
        '_03' => true,
        '_04' => true,
        '_05' => true,
        '_06' => true,
        '_07' => true,
        '_08' => true,
    ];

    /**
     * @var non-empty-list<TransactionSetInterface>
     */
    public array $ST = [];

    public function getId(): string
    {
        return 'GS';
    }
}
