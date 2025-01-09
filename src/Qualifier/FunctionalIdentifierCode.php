<?php

/*
 * Copyright (C) 2024 GT+ Logistics.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301
 * USA
 */

namespace Gtlogistics\EdiX12\Qualifier;

enum FunctionalIdentifierCode: string
{
    /**
     * Account Analysis (822).
     */
    case AA = 'AA';

    /**
     * Logistics Service Request (219).
     */
    case AB = 'AB';

    /**
     * Associated Data (102).
     */
    case AC = 'AC';

    /**
     * Individual Life, Annuity and Disability Application (267).
     */
    case AD = 'AD';

    /**
     * Premium Audit Request and Return (187).
     */
    case AE = 'AE';

    /**
     * Application for Admission to Educational Institutions (189).
     */
    case AF = 'AF';

    /**
     * Application Advice (824).
     */
    case AG = 'AG';

    /**
     * Logistics Service Response (220).
     */
    case AH = 'AH';

    /**
     * Automotive Inspection Detail (928).
     */
    case AI = 'AI';

    /**
     * Student Educational Record (Transcript) Acknowledgment (131).
     */
    case AK = 'AK';

    /**
     * Set Cancellation (998).
     */
    case AL = 'AL';

    /**
     * Item Information Request (893).
     */
    case AM = 'AM';

    /**
     * Return Merchandise Authorization and Notification (180).
     */
    case AN = 'AN';

    /**
     * Income or Asset Offset (521).
     */
    case AO = 'AO';

    /**
     * Abandoned Property Filings (103).
     */
    case AP = 'AP';

    /**
     * Customs Manifest (309).
     */
    case AQ = 'AQ';

    /**
     * Warehouse Stock Transfer Shipment Advice (943).
     */
    case AR = 'AR';

    /**
     * Transportation Appointment Schedule Information (163).
     */
    case AS = 'AS';

    /**
     * Animal Toxicological Data (249).
     */
    case AT = 'AT';

    /**
     * Customs Status Information (350).
     */
    case AU = 'AU';

    /**
     * Customs Carrier General Order Status (352).
     */
    case AV = 'AV';

    /**
     * Warehouse Inventory Adjustment Advice (947).
     */
    case AW = 'AW';

    /**
     * Customs Events Advisory Details (353).
     */
    case AX = 'AX';

    /**
     * Customs Automated Manifest Archive Status (354).
     */
    case AY = 'AY';

    /**
     * Customs Acceptance/Rejection (355).
     */
    case AZ = 'AZ';

    /**
     * Customs Permit to Transfer Request (356).
     */
    case BA = 'BA';

    /**
     * Customs In-Bond Information (357).
     */
    case BB = 'BB';

    /**
     * Business Credit Report (155).
     */
    case BC = 'BC';

    /**
     * Customs Consist Information (358).
     */
    case BD = 'BD';

    /**
     * Benefit Enrollment and Maintenance (834).
     */
    case BE = 'BE';

    /**
     * Business Entity Filings (105).
     */
    case BF = 'BF';

    /**
     * Customs Customer Profile Management (359).
     */
    case BG = 'BG';

    /**
     * Motor Carrier Bill of Lading (211).
     */
    case BL = 'BL';

    /**
     * Shipment and Billing Notice (857).
     */
    case BS = 'BS';

    /**
     * Purchase Order Change Acknowledgment/Request - Seller Initiated (865).
     */
    case CA = 'CA';

    /**
     * Unemployment Insurance Tax Claim or Charge Information (153).
     */
    case CB = 'CB';

    /**
     * Clauses and Provisions (504).
     */
    case CC = 'CC';

    /**
     * Credit/Debit Adjustment (812).
     */
    case CD = 'CD';

    /**
     * Cartage Work Assignment (222).
     */
    case CE = 'CE';

    /**
     * Corporate Financial Adjustment Information (844 and 849).
     */
    case CF = 'CF';

    /**
     * Car Handling Information (420).
     */
    case CH = 'CH';

    /**
     * Consolidated Service Invoice/Statement (811).
     */
    case CI = 'CI';

    /**
     * Manufacturer Coupon Family Code Structure (877).
     */
    case CJ = 'CJ';

    /**
     * Manufacturer Coupon Redemption Detail (881).
     */
    case CK = 'CK';

    /**
     * Election Campaign and Lobbyist Reporting (113).
     */
    case CL = 'CL';

    /**
     * Component Parts Content (871).
     */
    case CM = 'CM';

    /**
     * Coupon Notification (887).
     */
    case CN = 'CN';

    /**
     * Cooperative Advertising Agreements (290).
     */
    case CO = 'CO';

    /**
     * Electronic Proposal Information (251, 805).
     */
    case CP = 'CP';

    /**
     * Commodity Movement Services Response (874).
     */
    case CQ = 'CQ';

    /**
     * Rail Carhire Settlements (414).
     */
    case CR = 'CR';

    /**
     * Cryptographic Service Message (815).
     */
    case CS = 'CS';

    /**
     * Application Control Totals (831).
     */
    case CT = 'CT';

    /**
     * Commodity Movement Services (873).
     */
    case CU = 'CU';

    /**
     * Commercial Vehicle Safety and Credentials Information Exchange (285).
     */
    case CV = 'CV';

    /**
     * Educational Institution Record (133).
     */
    case CW = 'CW';

    /**
     * Contract Completion Status (567).
     */
    case D3 = 'D3';

    /**
     * Contract Abstract (561, 890).
     */
    case D4 = 'D4';

    /**
     * Contract Payment Management Report (568).
     */
    case D5 = 'D5';

    /**
     * Debit Authorization (828).
     */
    case DA = 'DA';

    /**
     * Shipment Delivery Discrepancy Information (854).
     */
    case DD = 'DD';

    /**
     * Market Development Fund Allocation (883).
     */
    case DF = 'DF';

    /**
     * Dealer Information (128).
     */
    case DI = 'DI';

    /**
     * Equipment Order (422).
     */
    case DM = 'DM';

    /**
     * Data Status Tracking (242).
     */
    case DS = 'DS';

    /**
     * Direct Exchange Delivery and Return Information (894, 895).
     */
    case DX = 'DX';

    /**
     * Educational Course Inventory (188).
     */
    case EC = 'EC';

    /**
     * Student Educational Record (Transcript) (130).
     */
    case ED = 'ED';

    /**
     * Railroad Equipment Inquiry or Advice (456).
     */
    case EI = 'EI';

    /**
     * Equipment Inspection (228).
     */
    case EN = 'EN';

    /**
     * Transportation Equipment Registration (603).
     */
    case EO = 'EO';

    /**
     * Environmental Compliance Reporting (179).
     */
    case EP = 'EP';

    /**
     * Revenue Receipts Statement (170).
     */
    case ER = 'ER';

    /**
     * Notice of Employment Status (540).
     */
    case ES = 'ES';

    /**
     * Railroad Event Report (451).
     */
    case EV = 'EV';

    /**
     * Excavation Communication (620).
     */
    case EX = 'EX';

    /**
     * Functional or Implementation Acknowledgment Transaction Sets (997, 999).
     */
    case FA = 'FA';

    /**
     * Freight Invoice (859).
     */
    case FB = 'FB';

    /**
     * Court and Law Enforcement Information (175, 176).
     */
    case FC = 'FC';

    /**
     * Motor Carrier Loading and Route Guide (217).
     */
    case FG = 'FG';

    /**
     * Financial Reporting (821, 827).
     */
    case FR = 'FR';

    /**
     * File Transfer (996).
     */
    case FT = 'FT';

    /**
     * Damage Claim Transaction Sets (920, 924, 925, 926).
     */
    case GC = 'GC';

    /**
     * General Request, Response or Confirmation (814).
     */
    case GE = 'GE';

    /**
     * Response to a Load Tender (990).
     */
    case GF = 'GF';

    /**
     * Intermodal Group Loading Plan (715).
     */
    case GL = 'GL';

    /**
     * Grocery Products Invoice (880).
     */
    case GP = 'GP';

    /**
     * Statistical Government Information (152).
     */
    case GR = 'GR';

    /**
     * Grant or Assistance Application (194).
     */
    case GT = 'GT';

    /**
     * Eligibility, Coverage or Benefit Information (271).
     */
    case HB = 'HB';

    /**
     * Health Care Claim (837).
     */
    case HC = 'HC';

    /**
     * Health Care Services Review Information (278).
     */
    case HI = 'HI';

    /**
     * Health Care Information Status Notification (277).
     */
    case HN = 'HN';

    /**
     * Health Care Claim Payment/Advice (835).
     */
    case HP = 'HP';

    /**
     * Health Care Claim Status Request (276).
     */
    case HR = 'HR';

    /**
     * Eligibility, Coverage or Benefit Inquiry (270).
     */
    case HS = 'HS';

    /**
     * Human Resource Information (132).
     */
    case HU = 'HU';

    /**
     * Health Care Benefit Coordination Verification (269).
     */
    case HV = 'HV';

    /**
     * Air Freight Details and Invoice (110, 980).
     */
    case IA = 'IA';

    /**
     * Inventory Inquiry/Advice (846).
     */
    case IB = 'IB';

    /**
     * Rail Advance Interchange Consist (418).
     */
    case IC = 'IC';

    /**
     * Insurance/Annuity Application Status (273).
     */
    case ID = 'ID';

    /**
     * Insurance Producer Administration (252).
     */
    case IE = 'IE';

    /**
     * Individual Insurance Policy and Client Information (111).
     */
    case IF = 'IF';

    /**
     * Direct Store Delivery Summary Information (882).
     */
    case IG = 'IG';

    /**
     * Commercial Vehicle Safety Reports (284).
     */
    case IH = 'IH';

    /**
     * Report of Injury, Illness or Incident (148).
     */
    case IJ = 'IJ';

    /**
     * Motor Carrier Freight Details and Invoice (210, 980).
     */
    case IM = 'IM';

    /**
     * Invoice Information (810).
     */
    case IN = 'IN';

    /**
     * Ocean Shipment Billing Details (310, 312, 980).
     */
    case IO = 'IO';

    /**
     * Rail Carrier Freight Details and Invoice (410, 980).
     */
    case IR = 'IR';

    /**
     * Estimated Time of Arrival and Car Scheduling (421).
     */
    case IS = 'IS';

    /**
     * Joint Interest Billing and Operating Expense Statement (819).
     */
    case JB = 'JB';

    /**
     * Commercial Vehicle Credentials (286).
     */
    case KM = 'KM';

    /**
     * Federal Communications Commission (FCC) License Application (195).
     */
    case LA = 'LA';

    /**
     * Lockbox (823).
     */
    case LB = 'LB';

    /**
     * Locomotive Information (436).
     */
    case LI = 'LI';

    /**
     * Property and Casualty Loss Notification (272).
     */
    case LN = 'LN';

    /**
     * Logistics Reassignment (536).
     */
    case LR = 'LR';

    /**
     * Asset Schedule (851).
     */
    case LS = 'LS';

    /**
     * Student Loan Transfer and Status Verification (144).
     */
    case LT = 'LT';

    /**
     * Motor Carrier Summary Freight Bill Manifest (224).
     */
    case MA = 'MA';

    /**
     * Request for Motor Carrier Rate Proposal (107).
     */
    case MC = 'MC';

    /**
     * Department of Defense Inventory Management (527).
     */
    case MD = 'MD';

    /**
     * Mortgage Origination (198, 200, 201, 245, 261, 262, 263, 833, 872).
     */
    case ME = 'ME';

    /**
     * Market Development Fund Settlement (884).
     */
    case MF = 'MF';

    /**
     * Mortgage Servicing Transaction Sets (203, 206, 259, 260, 264, 266).
     */
    case MG = 'MG';

    /**
     * Motor Carrier Rate Proposal (106).
     */
    case MH = 'MH';

    /**
     * Motor Carrier Shipment Status Inquiry (213).
     */
    case MI = 'MI';

    /**
     * Secondary Mortgage Market Loan Delivery (202).
     */
    case MJ = 'MJ';

    /**
     * Response to a Motor Carrier Rate Proposal (108).
     */
    case MK = 'MK';

    /**
     * Medical Event Reporting (500).
     */
    case MM = 'MM';

    /**
     * Mortgage Note (205).
     */
    case MN = 'MN';

    /**
     * Maintenance Service Order (650).
     */
    case MO = 'MO';

    /**
     * Motion Picture Booking Confirmation (159).
     */
    case MP = 'MP';

    /**
     * Consolidators Freight Bill and Invoice (223).
     */
    case MQ = 'MQ';

    /**
     * Multilevel Railcar Load Details (125).
     */
    case MR = 'MR';

    /**
     * Material Safety Data Sheet (848).
     */
    case MS = 'MS';

    /**
     * Electronic Form Structure (868).
     */
    case MT = 'MT';

    /**
     * Material Obligation Validation (517).
     */
    case MV = 'MV';

    /**
     * Rail Waybill Response (427).
     */
    case MW = 'MW';

    /**
     * Material Claim (847).
     */
    case MX = 'MX';

    /**
     * Response to a Cartage Work Assignment (225).
     */
    case MY = 'MY';

    /**
     * Motor Carrier Package Status (240).
     */
    case MZ = 'MZ';

    /**
     * Nonconformance Report (842).
     */
    case NC = 'NC';

    /**
     * Name and Address Lists (101).
     */
    case NL = 'NL';

    /**
     * Notice of Power of Attorney (157).
     */
    case NP = 'NP';

    /**
     * Secured Receipt or Acknowledgment (993).
     */
    case NR = 'NR';

    /**
     * Notice of Tax Adjustment or Assessment (149).
     */
    case NT = 'NT';

    /**
     * Cargo Insurance Advice of Shipment (362).
     */
    case OC = 'OC';

    /**
     * Order Group - Grocery (875, 876).
     */
    case OG = 'OG';

    /**
     * Organizational Relationships (816).
     */
    case OR = 'OR';

    /**
     * Warehouse Shipping Order (940).
     */
    case OW = 'OW';

    /**
     * Price Authorization Acknowledgment/Status (845).
     */
    case PA = 'PA';

    /**
     * Railroad Parameter Trace Registration (455).
     */
    case PB = 'PB';

    /**
     * Purchase Order Change Request - Buyer Initiated (860).
     */
    case PC = 'PC';

    /**
     * Product Activity Data (852).
     */
    case PD = 'PD';

    /**
     * Periodic Compensation (256).
     */
    case PE = 'PE';

    /**
     * Annuity Activity (268).
     */
    case PF = 'PF';

    /**
     * Insurance Plan Description (100).
     */
    case PG = 'PG';

    /**
     * Pricing History (503).
     */
    case PH = 'PH';

    /**
     * Patient Information (275).
     */
    case PI = 'PI';

    /**
     * Project Schedule Reporting (806).
     */
    case PJ = 'PJ';

    /**
     * Project Cost Reporting (839) and Contractor Cost Data Reporting (196).
     */
    case PK = 'PK';

    /**
     * Railroad Problem Log Inquiry or Advice (452).
     */
    case PL = 'PL';

    /**
     * Product Source Information (244).
     */
    case PN = 'PN';

    /**
     * Purchase Order (850).
     */
    case PO = 'PO';

    /**
     * Property Damage Report (112).
     */
    case PQ = 'PQ';

    /**
     * Purchase Order Acknowledgment (855).
     */
    case PR = 'PR';

    /**
     * Planning Schedule with Release Capability (830).
     */
    case PS = 'PS';

    /**
     * Product Transfer and Resale Report (867).
     */
    case PT = 'PT';

    /**
     * Motor Carrier Shipment Pickup Notification (216).
     */
    case PU = 'PU';

    /**
     * Purchase Order Shipment Management Document (250).
     */
    case PV = 'PV';

    /**
     * Healthcare Provider Information (274).
     */
    case PW = 'PW';

    /**
     * Payment Cancellation Request (829).
     */
    case PY = 'PY';

    /**
     * Product Information (878, 879, 888, 889, 896).
     */
    case QG = 'QG';

    /**
     * Transportation Carrier Shipment Status Message (214).
     */
    case QM = 'QM';

    /**
     * Ocean Shipment Status Information (313, 315).
     */
    case QO = 'QO';

    /**
     * Payment Order/Remittance Advice (820).
     */
    case RA = 'RA';

    /**
     * Railroad Clearance (470).
     */
    case RB = 'RB';

    /**
     * Receiving Advice/Acceptance Certificate (861).
     */
    case RC = 'RC';

    /**
     * Royalty Regulatory Report (185).
     */
    case RD = 'RD';

    /**
     * Warehouse Stock Receipt Advice (944).
     */
    case RE = 'RE';

    /**
     * Request for Routing Instructions (753).
     */
    case RF = 'RF';

    /**
     * Routing Instructions (754).
     */
    case RG = 'RG';

    /**
     * Railroad Reciprocal Switch File (433).
     */
    case RH = 'RH';

    /**
     * Routing and Carrier Instruction (853).
     */
    case RI = 'RI';

    /**
     * Railroad Mark Register Update Activity (434).
     */
    case RJ = 'RJ';

    /**
     * Standard Transportation Commodity Code Master (435).
     */
    case RK = 'RK';

    /**
     * Rail Industrial Switch List (423).
     */
    case RL = 'RL';

    /**
     * Railroad Station Master File (431).
     */
    case RM = 'RM';

    /**
     * Requisition Transaction (511).
     */
    case RN = 'RN';

    /**
     * Ocean Booking Information (300, 301, 303).
     */
    case RO = 'RO';

    /**
     * Commission Sales Report (818).
     */
    case RP = 'RP';

    /**
     * Request for Quotation (840) and Procurement Notices (836).
     */
    case RQ = 'RQ';

    /**
     * Response to Request For Quotation (843).
     */
    case RR = 'RR';

    /**
     * Order Status Information (869, 870).
     */
    case RS = 'RS';

    /**
     * Report of Test Results (863).
     */
    case RT = 'RT';

    /**
     * Railroad Retirement Activity (429).
     */
    case RU = 'RU';

    /**
     * Railroad Junctions and Interchanges Activity (437).
     */
    case RV = 'RV';

    /**
     * Rail Revenue Waybill (426).
     */
    case RW = 'RW';

    /**
     * Rail Car Hire Rate Negotiation.
     */
    case RX = 'RX';

    /**
     * Request for Student Educational Record (Transcript) (146).
     */
    case RY = 'RY';

    /**
     * Response to Request for Student Educational Record (Transcript) (147).
     */
    case RZ = 'RZ';

    /**
     * Air Shipment Information (104).
     */
    case SA = 'SA';

    /**
     * Rail Carrier Services Settlement (424).
     */
    case SB = 'SB';

    /**
     * Price/Sales Catalog (832, 897).
     */
    case SC = 'SC';

    /**
     * Student Loan Pre-Claims and Claims (191).
     */
    case SD = 'SD';

    /**
     * Shipper's Export Declaration (601).
     */
    case SE = 'SE';

    /**
     * Customs Manifest (309).
     */
    case SF = 'SF';

    /**
     * Ship Notice/Manifest (856).
     */
    case SH = 'SH';

    /**
     * Shipment Information (858).
     */
    case SI = 'SI';

    /**
     * Transportation Automatic Equipment Identification (160).
     */
    case SJ = 'SJ';

    /**
     * Student Aid Origination Record (135, 139).
     */
    case SL = 'SL';

    /**
     * Motor Carrier Load Tender (204).
     */
    case SM = 'SM';

    /**
     * Rail Route File Maintenance (475).
     */
    case SN = 'SN';

    /**
     * Ocean Shipment Information (304, 311, 317, 319, 322, 323, 324, 325, 326, 361).
     */
    case SO = 'SO';

    /**
     * Specifications/Technical Information (841).
     */
    case SP = 'SP';

    /**
     * Production Sequence (866).
     */
    case SQ = 'SQ';

    /**
     * Rail Carrier Shipment Information (404, 419).
     */
    case SR = 'SR';

    /**
     * Shipping Schedule (862).
     */
    case SS = 'SS';

    /**
     * Railroad Service Commitment Advice (453).
     */
    case ST = 'ST';

    /**
     * Account Assignment/Inquiry and Service/Status (248).
     */
    case SU = 'SU';

    /**
     * Student Enrollment Verification (190).
     */
    case SV = 'SV';

    /**
     * Warehouse Shipping Advice (945).
     */
    case SW = 'SW';

    /**
     * Electronic Filing of Tax Return Data Acknowledgment (151).
     */
    case TA = 'TA';

    /**
     * Trailer or Container Repair Billing (412).
     */
    case TB = 'TB';

    /**
     * Trading Partner Profile (838).
     */
    case TD = 'TD';

    /**
     * Tax or Fee Exemption Certification (283).
     */
    case TE = 'TE';

    /**
     * Electronic Filing of Tax Return Data (813).
     */
    case TF = 'TF';

    /**
     * Tax Information Exchange (826).
     */
    case TI = 'TI';

    /**
     * Tax Jurisdiction Sourcing (158).
     */
    case TJ = 'TJ';

    /**
     * Motor Carrier Delivery Trailer Manifest (212).
     */
    case TM = 'TM';

    /**
     * Tax Rate Notification (150).
     */
    case TN = 'TN';

    /**
     * Real Estate Title Services (197, 199, 265, 485, 486).
     */
    case TO = 'TO';

    /**
     * Rail Rate Transactions (460, 463, 466, 468, 485, 486, 490, 492, 494).
     */
    case TP = 'TP';

    /**
     * Train Sheet (161).
     */
    case TR = 'TR';

    /**
     * Educational Testing and Prospect Request and Report (138).
     */
    case TT = 'TT';

    /**
     * Trailer Usage Report (227).
     */
    case TU = 'TU';

    /**
     * Text Message (864).
     */
    case TX = 'TX';

    /**
     * Retail Account Characteristics (885).
     */
    case UA = 'UA';

    /**
     * Customer Call Reporting (886).
     */
    case UB = 'UB';

    /**
     * Secured Interest Filing (154).
     */
    case UC = 'UC';

    /**
     * Deduction Research Report (891).
     */
    case UD = 'UD';

    /**
     * Underwriting Information Services (255).
     */
    case UI = 'UI';

    /**
     * Motor Carrier Pickup Manifest (215).
     */
    case UP = 'UP';

    /**
     * Insurance Underwriting Requirements Reporting (186).
     */
    case UW = 'UW';

    /**
     * Vehicle Application Advice (126).
     */
    case VA = 'VA';

    /**
     * Vehicle Baying Order (127).
     */
    case VB = 'VB';

    /**
     * Vehicle Shipping Order (120).
     */
    case VC = 'VC';

    /**
     * Vehicle Damage (124).
     */
    case VD = 'VD';

    /**
     * Vessel Content Details (109).
     */
    case VE = 'VE';

    /**
     * Vehicle Carrier Rate Update (129).
     */
    case VH = 'VH';

    /**
     * Voter Registration Information (280).
     */
    case VI = 'VI';

    /**
     * Vehicle Service (121).
     */
    case VS = 'VS';

    /**
     * Product Service Transaction Sets (140, 141, 142, 143).
     */
    case WA = 'WA';

    /**
     * Rail Carrier Waybill Interchange (417).
     */
    case WB = 'WB';

    /**
     * Vendor Performance Review (501, 892).
     */
    case WG = 'WG';

    /**
     * Wage Determination (288).
     */
    case WI = 'WI';

    /**
     * Well Information (625).
     */
    case WL = 'WL';

    /**
     * Shipment Weights (440).
     */
    case WR = 'WR';

    /**
     * Rail Waybill Request (425).
     */
    case WT = 'WT';
}
