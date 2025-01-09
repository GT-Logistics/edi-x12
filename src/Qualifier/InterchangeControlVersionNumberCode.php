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

enum InterchangeControlVersionNumberCode: string
{
    /**
     * ASC X12 Standards Issued by ANSI in 1987.
     */
    case _00200 = '00200';

    /**
     * Draft Standards for Trial Use Approved by ASC X12 Through August 1988.
     */
    case _00201 = '00201';

    /**
     * Draft Standards for Trial Use Approved by ASC X12 Through May 1989.
     */
    case _00204 = '00204';

    /**
     * ASC X12 Standards Issued by ANSI in 1992.
     */
    case _00300 = '00300';

    /**
     * Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board Through October 1990.
     */
    case _00301 = '00301';

    /**
     * Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board Through October 1991.
     */
    case _00302 = '00302';

    /**
     * Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board Through October 1992.
     */
    case _00303 = '00303';

    /**
     * Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board through October 1993.
     */
    case _00304 = '00304';

    /**
     * Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board through October 1994.
     */
    case _00305 = '00305';

    /**
     * Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board through October 1995.
     */
    case _00306 = '00306';

    /**
     * Draft Standards for Trial Use Approved for Publication by ASC X12 Procedures Review Board through October 1996.
     */
    case _00307 = '00307';

    /**
     * ASC X12 Standards Issued by ANSI in 1997.
     */
    case _00400 = '00400';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 1997.
     */
    case _00401 = '00401';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 1998.
     */
    case _00402 = '00402';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 1999.
     */
    case _00403 = '00403';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2000.
     */
    case _00404 = '00404';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2001.
     */
    case _00405 = '00405';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2002.
     */
    case _00406 = '00406';

    /**
     * ASC X12 Standards Issued by ANSI in 2003.
     */
    case _00500 = '00500';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2003.
     */
    case _00501 = '00501';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2004.
     */
    case _00502 = '00502';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2005.
     */
    case _00503 = '00503';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2006.
     */
    case _00504 = '00504';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2007.
     */
    case _00505 = '00505';

    /**
     * ASC X12 Standards Issued by ANSI in 2008.
     */
    case _00600 = '00600';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2008.
     */
    case _00601 = '00601';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2009.
     */
    case _00602 = '00602';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2010.
     */
    case _00603 = '00603';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2011.
     */
    case _00604 = '00604';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2012.
     */
    case _00605 = '00605';

    /**
     * ASC X12 Standards Issued by ANSI in 2013.
     */
    case _00700 = '00700';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2013.
     */
    case _00701 = '00701';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2014.
     */
    case _00702 = '00702';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2015.
     */
    case _00703 = '00703';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2016.
     */
    case _00704 = '00704';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through December 2017.
     */
    case _00705 = '00705';

    /**
     * 00706 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2018.
     */
    case _00706 = '00706';

    /**
     * ASC X12 Standards Issued by ANSI in 2019.
     */
    case _00800 = '00800';

    /**
     * 00801 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2019.
     */
    case _00801 = '00801';

    /**
     * 00802 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2020.
     */
    case _00802 = '00802';

    /**
     * 00803 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2021.
     */
    case _00803 = '00803';

    /**
     * 00804 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2022.
     */
    case _00804 = '00804';

    /**
     * 00805 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2023.
     */
    case _00805 = '00805';
}
