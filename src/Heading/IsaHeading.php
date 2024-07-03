<?php

declare(strict_types=1);

namespace Gtlogistics\EdiX12\Heading;

use Gtlogistics\EdiX12\Model\AbstractSegment;

/**
 * @property "00"|"01"|"02"|"03"|"04"|"05"|"06"|"07"|"08" $_01 **Authorization Information Qualifier:** Code identifying the type of information in the Authorization Information
 *                                                             - 00: No Authorization Information Present (No Meaningful Information in I02)
 *                                                             - 01: UCS Communications ID
 *                                                             - 02: EDX Communications ID
 *                                                             - 03: Additional Data Identification
 *                                                             - 04: Rail Communications ID
 *                                                             - 05: Department of Defense (DoD) Communication Identifier
 *                                                             - 06: United States Federal Government Communication Identifier
 *                                                             - 07: Truck Communications ID
 *                                                             - 08: Ocean Communications ID
 * @property string $_02 **Authorization Information:** Information used for additional identification or authorization of the interchange sender or the data in the interchange; the type of information is set by the Authorization Information Qualifier (I01)
 * @property "00"|"01" $_03 **Security Information Qualifier:** Code identifying the type of information in the Security Information
 *                          - 00: No Security Information Present (No Meaningful Information in I04)
 *                          - 01: Password
 * @property string $_04 **Security Information:** This is used for identifying the security information about the interchange sender or the data in the interchange; the type of information is set by the Security Information Qualifier (I03)
 * @property "01"|"02"|"03"|"04"|"07"|"08"|"09"|"10"|"11"|"12"|"13"|"14"|"15"|"16"|"17"|"18"|"19"|"20"|"21"|"22"|"23"|"24"|"25"|"26"|"27"|"28"|"29"|"30"|"31"|"32"|"33"|"34"|"35"|"36"|"37"|"38"|"AM"|"NR"|"SA"|"SN"|"ZZ" $_05 **Interchange ID Qualifier:** Code indicating the system/method of code structure used to designate the sender or receiver ID element being qualified
 *                                                                                                                                                                                                                             - 01: Duns (Dun & Bradstreet)
 *                                                                                                                                                                                                                             - 02: SCAC (Standard Carrier Alpha Code)
 *                                                                                                                                                                                                                             - 03: FMC (Federal Maritime Commission)
 *                                                                                                                                                                                                                             - 04: IATA (International Air Transport Association)
 *                                                                                                                                                                                                                             - 07: Global Location Number (GLN)
 *                                                                                                                                                                                                                             - 08: UCC EDI Communications ID (Comm ID)
 *                                                                                                                                                                                                                             - 09: X.121 (CCITT)
 *                                                                                                                                                                                                                             - 10: Department of Defense (DoD) Activity Address Code
 *                                                                                                                                                                                                                             - 11: DEA (Drug Enforcement Administration)
 *                                                                                                                                                                                                                             - 12: Phone (Telephone Companies)
 *                                                                                                                                                                                                                             - 13: UCS Code (The UCS Code is a Code Used for UCS Transmissions; it includes the Area Code and Telephone Number of a Modem; it Does Not Include Punctuation, Blanks or Access Code)
 *                                                                                                                                                                                                                             - 14: Duns Plus Suffix
 *                                                                                                                                                                                                                             - 15: Petroleum Accountants Society of Canada Company Code
 *                                                                                                                                                                                                                             - 16: Duns Number With 4-Character Suffix
 *                                                                                                                                                                                                                             - 17: American Bankers Association (ABA) Transit Routing Number (Including Check Digit, 9 Digit)
 *                                                                                                                                                                                                                             - 18: Association of American Railroads (AAR) Standard Distribution Code
 *                                                                                                                                                                                                                             - 19: EDI Council of Australia (EDICA) Communications ID Number (COMM ID)
 *                                                                                                                                                                                                                             - 20: Health Industry Number (HIN)
 *                                                                                                                                                                                                                             - 21: Integrated Postsecondary Education Data System, or (IPEDS)
 *                                                                                                                                                                                                                             - 22: Federal Interagency Commission on Education, or FICE
 *                                                                                                                                                                                                                             - 23: National Center for Education Statistics Common Core of Data 12-Digit Number for Pre-K-Grade 12 Institutes, or NCES
 *                                                                                                                                                                                                                             - 24: The College Board's Admission Testing Program 4-Digit Code of Postsecondary Institutes, or ATP
 *                                                                                                                                                                                                                             - 25: ACT, Inc. 4-Digit Code of Postsecondary Institutions.
 *                                                                                                                                                                                                                             - 26: Statistics of Canada List of Postsecondary Institutions
 *                                                                                                                                                                                                                             - 27: Carrier Identification Number as assigned by Centers for Medicare & Medicaid Services (CMS)
 *                                                                                                                                                                                                                             - 28: Fiscal Intermediary Identification Number as assigned by Centers for Medicare & Medicaid Services (CMS)
 *                                                                                                                                                                                                                             - 29: Medicare Provider and Supplier Identification Number as assigned by Centers for Medicare & Medicaid Services (CMS)
 *                                                                                                                                                                                                                             - 30: U.S. Federal Tax Identification Number
 *                                                                                                                                                                                                                             - 31: Jurisdiction Identification Number Plus 4 as assigned by the International Association of Industrial Accident Boards and Commissions (IAIABC)
 *                                                                                                                                                                                                                             - 32: U.S. Federal Employer Identification Number (FEIN)
 *                                                                                                                                                                                                                             - 33: National Association of Insurance Commissioners Company Code (NAIC)
 *                                                                                                                                                                                                                             - 34: Medicaid Provider and Supplier Identification Number as assigned by individual State Medicaid Agencies in conjunction with Centers for Medicare & Medicaid Services (CMS)
 *                                                                                                                                                                                                                             - 35: Statistics Canada Canadian College Student Information System Institution Codes
 *                                                                                                                                                                                                                             - 36: Statistics Canada University Student Information System Institution Codes
 *                                                                                                                                                                                                                             - 37: Society of Property Information Compilers and Analysts
 *                                                                                                                                                                                                                             - 38: The College Board and ACT, Inc. 6-Digit Code List of Secondary Institutions
 *                                                                                                                                                                                                                             - AM: Association Mexicana del Codigo de Producto (AMECOP) Communication ID
 *                                                                                                                                                                                                                             - NR: National Retail Merchants Association (NRMA) - Assigned
 *                                                                                                                                                                                                                             - SA: User Identification Number as assigned by the Safety and Fitness Electronic Records (SAFER) System
 *                                                                                                                                                                                                                             - SN: Standard Address Number
 *                                                                                                                                                                                                                             - ZZ: Mutually Defined
 * @property string $_06 **Interchange Sender ID:** Identification code published by the sender for other parties to use as the receiver ID to route data to them; the sender always codes this value in the sender ID element
 * @property "01"|"02"|"03"|"04"|"07"|"08"|"09"|"10"|"11"|"12"|"13"|"14"|"15"|"16"|"17"|"18"|"19"|"20"|"21"|"22"|"23"|"24"|"25"|"26"|"27"|"28"|"29"|"30"|"31"|"32"|"33"|"34"|"35"|"36"|"37"|"38"|"AM"|"NR"|"SA"|"SN"|"ZZ" $_07 **Interchange ID Qualifier:** Code indicating the system/method of code structure used to designate the sender or receiver ID element being qualified
 *                                                                                                                                                                                                                             - 01: Duns (Dun & Bradstreet)
 *                                                                                                                                                                                                                             - 02: SCAC (Standard Carrier Alpha Code)
 *                                                                                                                                                                                                                             - 03: FMC (Federal Maritime Commission)
 *                                                                                                                                                                                                                             - 04: IATA (International Air Transport Association)
 *                                                                                                                                                                                                                             - 07: Global Location Number (GLN)
 *                                                                                                                                                                                                                             - 08: UCC EDI Communications ID (Comm ID)
 *                                                                                                                                                                                                                             - 09: X.121 (CCITT)
 *                                                                                                                                                                                                                             - 10: Department of Defense (DoD) Activity Address Code
 *                                                                                                                                                                                                                             - 11: DEA (Drug Enforcement Administration)
 *                                                                                                                                                                                                                             - 12: Phone (Telephone Companies)
 *                                                                                                                                                                                                                             - 13: UCS Code (The UCS Code is a Code Used for UCS Transmissions; it includes the Area Code and Telephone Number of a Modem; it Does Not Include Punctuation, Blanks or Access Code)
 *                                                                                                                                                                                                                             - 14: Duns Plus Suffix
 *                                                                                                                                                                                                                             - 15: Petroleum Accountants Society of Canada Company Code
 *                                                                                                                                                                                                                             - 16: Duns Number With 4-Character Suffix
 *                                                                                                                                                                                                                             - 17: American Bankers Association (ABA) Transit Routing Number (Including Check Digit, 9 Digit)
 *                                                                                                                                                                                                                             - 18: Association of American Railroads (AAR) Standard Distribution Code
 *                                                                                                                                                                                                                             - 19: EDI Council of Australia (EDICA) Communications ID Number (COMM ID)
 *                                                                                                                                                                                                                             - 20: Health Industry Number (HIN)
 *                                                                                                                                                                                                                             - 21: Integrated Postsecondary Education Data System, or (IPEDS)
 *                                                                                                                                                                                                                             - 22: Federal Interagency Commission on Education, or FICE
 *                                                                                                                                                                                                                             - 23: National Center for Education Statistics Common Core of Data 12-Digit Number for Pre-K-Grade 12 Institutes, or NCES
 *                                                                                                                                                                                                                             - 24: The College Board's Admission Testing Program 4-Digit Code of Postsecondary Institutes, or ATP
 *                                                                                                                                                                                                                             - 25: ACT, Inc. 4-Digit Code of Postsecondary Institutions.
 *                                                                                                                                                                                                                             - 26: Statistics of Canada List of Postsecondary Institutions
 *                                                                                                                                                                                                                             - 27: Carrier Identification Number as assigned by Centers for Medicare & Medicaid Services (CMS)
 *                                                                                                                                                                                                                             - 28: Fiscal Intermediary Identification Number as assigned by Centers for Medicare & Medicaid Services (CMS)
 *                                                                                                                                                                                                                             - 29: Medicare Provider and Supplier Identification Number as assigned by Centers for Medicare & Medicaid Services (CMS)
 *                                                                                                                                                                                                                             - 30: U.S. Federal Tax Identification Number
 *                                                                                                                                                                                                                             - 31: Jurisdiction Identification Number Plus 4 as assigned by the International Association of Industrial Accident Boards and Commissions (IAIABC)
 *                                                                                                                                                                                                                             - 32: U.S. Federal Employer Identification Number (FEIN)
 *                                                                                                                                                                                                                             - 33: National Association of Insurance Commissioners Company Code (NAIC)
 *                                                                                                                                                                                                                             - 34: Medicaid Provider and Supplier Identification Number as assigned by individual State Medicaid Agencies in conjunction with Centers for Medicare & Medicaid Services (CMS)
 *                                                                                                                                                                                                                             - 35: Statistics Canada Canadian College Student Information System Institution Codes
 *                                                                                                                                                                                                                             - 36: Statistics Canada University Student Information System Institution Codes
 *                                                                                                                                                                                                                             - 37: Society of Property Information Compilers and Analysts
 *                                                                                                                                                                                                                             - 38: The College Board and ACT, Inc. 6-Digit Code List of Secondary Institutions
 *                                                                                                                                                                                                                             - AM: Association Mexicana del Codigo de Producto (AMECOP) Communication ID
 *                                                                                                                                                                                                                             - NR: National Retail Merchants Association (NRMA) - Assigned
 *                                                                                                                                                                                                                             - SA: User Identification Number as assigned by the Safety and Fitness Electronic Records (SAFER) System
 *                                                                                                                                                                                                                             - SN: Standard Address Number
 *                                                                                                                                                                                                                             - ZZ: Mutually Defined
 * @property string $_08 **Interchange Receiver ID:** Identification code published by the receiver of the data; When sending, it is used by the sender as their sending ID, thus other parties sending to them will use this as a receiving ID to route data to them
 * @property \DateTimeInterface $_09 **Interchange Date:** Date of the interchange
 * @property \DateTimeInterface $_10 **Interchange Time:** Time of the interchange
 * @property string $_11 **Repetition Separator:** The repetition separator is a delimiter and not a data element; this field provides the delimiter used to separate repeated occurrences of a simple data element or a composite data structure; this value must be different than the data element separator, component element separator, and the segment terminator
 * @property string $_12 **Interchange Control Version Number Code:** Code indicating the system/method of code structure used to designate the sender or receiver ID element being qualified
 *                       - 00200: ASC X12 Standards Issued by ANSI in 1987
 *                       - 00200: ASC X12 Standards Issued by ANSI in 1987
 *                       - 00201: Draft Standards for Trial Use Approved by ASC X12 Through August 1988
 *                       - 00204: Draft Standards for Trial Use Approved by ASC X12 Through May 1989
 *                       - 00300: ASC X12 Standards Issued by ANSI in 1992
 *                       - 00301: Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board Through October 1990
 *                       - 00302: Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board Through October 1991
 *                       - 00303: Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board Through October 1992
 *                       - 00304: Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board through October 1993
 *                       - 00305: Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board through October 1994
 *                       - 00306: Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board through October 1995
 *                       - 00307: Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board through October 1996
 *                       - 00400: ASC X12 Standards Issued by ANSI in 1997
 *                       - 00401: Standards Approved for Publication by ASC X12 Procedures Review Board through October 1997
 *                       - 00402: Standards Approved for Publication by ASC X12 Procedures Review Board through October 1998
 *                       - 00403: Standards Approved for Publication by ASC X12 Procedures Review Board through October 1999
 *                       - 00404: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2000
 *                       - 00405: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2001
 *                       - 00406: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2002
 *                       - 00500: ASC X12 Standards Issued by ANSI in 2003
 *                       - 00501: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2003
 *                       - 00502: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2004
 *                       - 00503: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2005
 *                       - 00504: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2006
 *                       - 00505: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2007
 *                       - 00600: ASC X12 Standards Issued by ANSI in 2008
 *                       - 00601: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2008
 *                       - 00602: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2009
 *                       - 00603: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2010
 *                       - 00604: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2011
 *                       - 00605: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2012
 *                       - 00700: ASC X12 Standards Issued by ANSI in 2013
 *                       - 00701: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2013
 *                       - 00702: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2014
 *                       - 00703: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2015
 *                       - 00704: Standards Approved for Publication by ASC X12 Procedures Review Board through October 2016
 *                       - 00705: Standards Approved for Publication by ASC X12 Procedures Review Board through December 2017
 *                       - 00706: 00706 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2018
 *                       - 00800: ASC X12 Standards Issued by ANSI in 2019
 *                       - 00801: 00801 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2019
 *                       - 00802: 00802 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2020
 *                       - 00803: 00803 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2021
 *                       - 00804: 00804 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2022
 *                       - 00805: 00805 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2023
 * @property int $_13 **Interchange Control Number:** A control number assigned by the interchange sender
 * @property "0"|"1"|"2"|"3" $_14 **Acknowledgment Requested Code:** Code indicating sender's request for an interchange acknowledgment
 *                                - 0: No Interchange Acknowledgment Requested
 *                                - 1: Interchange Acknowledgment Requested (TA1)
 *                                - 2: Interchange Acknowledgment Requested only when Interchange is "Rejected Because Of Errors"
 *                                - 3: Interchange Acknowledgment Requested only when Interchange is "Rejected Because Of Errors" or "Accepted but Errors are Noted"
 * @property "I"|"P"|"T" $_15 **Interchange Usage Indicator Code:** Code indicating whether data enclosed by this interchange envelope is test, production or information
 *                            - I: Information
 *                            - P: Production Data
 *                            - T: Test Data
 * @property string $_16 **Component Element Separator:** The component element separator is a delimiter and not a data element; this field provides the delimiter used to separate component data elements within a composite data structure; this value must be different than the data element separator and the segment terminator
 */
final class IsaHeading extends AbstractSegment
{
    /**
     * @var GsHeading[]
     */
    public array $GS = [];

    protected array $castings = [
        9 => 'date',
        10 => 'time',
        13 => 'int',
    ];

    protected array $lengths = [
        2 => [10, 10],
        4 => [10, 10],
        6 => [15, 15],
        8 => [15, 15],
        9 => [6, 6],
        10 => [4, 4],
        13 => [9, 9],
        16 => [1, 1],
    ];

    protected array $required = [
        1 => true,
        2 => true,
        3 => true,
        4 => true,
        5 => true,
        6 => true,
        7 => true,
        8 => true,
        9 => true,
        10 => true,
        11 => true,
        12 => true,
        13 => true,
        14 => true,
        15 => true,
        16 => true,
    ];

    public function getId(): string
    {
        return 'ISA';
    }
}
