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

enum InterchangeIDQualifier: string
{
    /**
     * Duns (Dun & Bradstreet).
     */
    case _01 = '01';

    /**
     * SCAC (Standard Carrier Alpha Code).
     */
    case _02 = '02';

    /**
     * FMC (Federal Maritime Commission).
     */
    case _03 = '03';

    /**
     * IATA (International Air Transport Association).
     */
    case _04 = '04';

    /**
     * Global Location Number (GLN).
     */
    case _07 = '07';

    /**
     * UCC EDI Communications ID (Comm ID).
     */
    case _08 = '08';

    /**
     * X.121 (CCITT).
     */
    case _09 = '09';

    /**
     * Department of Defense (DoD) Activity Address Code.
     */
    case _10 = '10';

    /**
     * DEA (Drug Enforcement Administration).
     */
    case _11 = '11';

    /**
     * Phone (Telephone Companies).
     */
    case _12 = '12';

    /**
     * UCS Code (The UCS Code is a Code Used for UCS Transmissions; it includes the Area Code and Telephone Number of a Modem; it Does Not Include Punctuation, Blanks or Access Code).
     */
    case _13 = '13';

    /**
     * Duns Plus Suffix.
     */
    case _14 = '14';

    /**
     * Petroleum Accountants Society of Canada Company Code.
     */
    case _15 = '15';

    /**
     * Duns Number With 4-Character Suffix.
     */
    case _16 = '16';

    /**
     * American Bankers Association (ABA) Transit Routing Number (Including Check Digit, 9 Digit).
     */
    case _17 = '17';

    /**
     * Association of American Railroads (AAR) Standard Distribution Code.
     */
    case _18 = '18';

    /**
     * EDI Council of Australia (EDICA) Communications ID Number (COMM ID).
     */
    case _19 = '19';

    /**
     * Health Industry Number (HIN).
     */
    case _20 = '20';

    /**
     * Integrated Postsecondary Education Data System, or (IPEDS).
     */
    case _21 = '21';

    /**
     * Federal Interagency Commission on Education, or FICE.
     */
    case _22 = '22';

    /**
     * National Center for Education Statistics Common Core of Data 12-Digit Number for Pre-K-Grade 12 Institutes, or NCES.
     */
    case _23 = '23';

    /**
     * The College Board's Admission Testing Program 4-Digit Code of Postsecondary Institutes, or ATP.
     */
    case _24 = '24';

    /**
     * ACT, Inc. 4-Digit Code of Postsecondary Institutions.
     */
    case _25 = '25';

    /**
     * Statistics of Canada List of Postsecondary Institutions.
     */
    case _26 = '26';

    /**
     * Carrier Identification Number as assigned by Centers for Medicare & Medicaid Services (CMS).
     */
    case _27 = '27';

    /**
     * Fiscal Intermediary Identification Number as assigned by Centers for Medicare & Medicaid Services (CMS).
     */
    case _28 = '28';

    /**
     * Medicare Provider and Supplier Identification Number as assigned by Centers for Medicare & Medicaid Services (CMS).
     */
    case _29 = '29';

    /**
     * U.S. Federal Tax Identification Number.
     */
    case _30 = '30';

    /**
     * Jurisdiction Identification Number Plus 4 as assigned by the International Association of Industrial Accident Boards and Commissions (IAIABC).
     */
    case _31 = '31';

    /**
     * U.S. Federal Employer Identification Number (FEIN).
     */
    case _32 = '32';

    /**
     * National Association of Insurance Commissioners Company Code (NAIC).
     */
    case _33 = '33';

    /**
     * Medicaid Provider and Supplier Identification Number as assigned by individual State Medicaid Agencies in conjunction with Centers for Medicare & Medicaid Services (CMS).
     */
    case _34 = '34';

    /**
     * Statistics Canada Canadian College Student Information System Institution Codes.
     */
    case _35 = '35';

    /**
     * Statistics Canada University Student Information System Institution Codes.
     */
    case _36 = '36';

    /**
     * Society of Property Information Compilers and Analysts.
     */
    case _37 = '37';

    /**
     * The College Board and ACT, Inc. 6-Digit Code List of Secondary Institutions.
     */
    case _38 = '38';

    /**
     * Association Mexicana del Codigo de Producto (AMECOP) Communication ID.
     */
    case AM = 'AM';

    /**
     * National Retail Merchants Association (NRMA) - Assigned.
     */
    case NR = 'NR';

    /**
     * User Identification Number as assigned by the Safety and Fitness Electronic Records (SAFER) System.
     */
    case SA = 'SA';

    /**
     * Standard Address Number.
     */
    case SN = 'SN';

    /**
     * Mutually Defined.
     */
    case ZZ = 'ZZ';
}
