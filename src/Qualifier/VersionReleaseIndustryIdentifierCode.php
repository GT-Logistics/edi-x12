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

enum VersionReleaseIndustryIdentifierCode: string
{
    /**
     * ASC X12 Standards Approved by ANSI in 1983.
     */
    case _001000 = '001000';

    /**
     * ASC X12 Standards Approved by ANSI in 1986.
     */
    case _002000 = '002000';

    /**
     * Draft Standards Approved by ASC X12 in November 1987.
     */
    case _002001 = '002001';

    /**
     * Draft Standards Approved by ASC X12 through February 1988.
     */
    case _002002 = '002002';

    /**
     * Draft Standards Approved by ASC X12 through August 1988.
     */
    case _002003 = '002003';

    /**
     * Draft Standards Approved by ASC X12 through February 1989.
     */
    case _002031 = '002031';

    /**
     * Draft Standards Approved by ASC X12 through May 1989.
     */
    case _002040 = '002040';

    /**
     * Draft Standards Approved by ASC X12 through October 1989.
     */
    case _002041 = '002041';

    /**
     * Draft Standards Approved by ASC X12 through February 1990.
     */
    case _002042 = '002042';

    /**
     * ASC X12 Standards Approved by ANSI in 1992.
     */
    case _003000 = '003000';

    /**
     * Draft Standards Approved by ASC X12 through June 1990.
     */
    case _003010 = '003010';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through February 1991.
     */
    case _003011 = '003011';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through June 1991.
     */
    case _003012 = '003012';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through October 1991.
     */
    case _003020 = '003020';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through February 1992.
     */
    case _003021 = '003021';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through June 1992.
     */
    case _003022 = '003022';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through October 1992.
     */
    case _003030 = '003030';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through February 1993.
     */
    case _003031 = '003031';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through June 1993.
     */
    case _003032 = '003032';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through October 1993.
     */
    case _003040 = '003040';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through February 1994.
     */
    case _003041 = '003041';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through June 1994.
     */
    case _003042 = '003042';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through October 1994.
     */
    case _003050 = '003050';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through February 1995.
     */
    case _003051 = '003051';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through June 1995.
     */
    case _003052 = '003052';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through October 1995.
     */
    case _003060 = '003060';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through February 1996.
     */
    case _003061 = '003061';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through June 1996.
     */
    case _003062 = '003062';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through October 1996.
     */
    case _003070 = '003070';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through February 1997.
     */
    case _003071 = '003071';

    /**
     * Draft Standards Approved for Publication by ASC X12 Procedures Review Board through June 1997.
     */
    case _003072 = '003072';

    /**
     * ASC X12 Standards Approved by ANSI in 1997.
     */
    case _004000 = '004000';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 1997.
     */
    case _004010 = '004010';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 1998.
     */
    case _004011 = '004011';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 1998.
     */
    case _004012 = '004012';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 1998.
     */
    case _004020 = '004020';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 1999.
     */
    case _004021 = '004021';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 1999.
     */
    case _004022 = '004022';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 1999.
     */
    case _004030 = '004030';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2000.
     */
    case _004031 = '004031';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2000.
     */
    case _004032 = '004032';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2000.
     */
    case _004040 = '004040';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2001.
     */
    case _004041 = '004041';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2001.
     */
    case _004042 = '004042';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2001.
     */
    case _004050 = '004050';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2002.
     */
    case _004051 = '004051';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2002.
     */
    case _004052 = '004052';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2002.
     */
    case _004060 = '004060';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2003.
     */
    case _004061 = '004061';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2003.
     */
    case _004062 = '004062';

    /**
     * ASC X12 Standards Approved by ANSI in 2003.
     */
    case _005000 = '005000';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2003.
     */
    case _005010 = '005010';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2004.
     */
    case _005011 = '005011';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2004.
     */
    case _005012 = '005012';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2004.
     */
    case _005020 = '005020';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2005.
     */
    case _005021 = '005021';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2005.
     */
    case _005022 = '005022';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2005.
     */
    case _005030 = '005030';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2006.
     */
    case _005031 = '005031';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2006.
     */
    case _005032 = '005032';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2006.
     */
    case _005040 = '005040';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2007.
     */
    case _005041 = '005041';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2007.
     */
    case _005042 = '005042';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2007.
     */
    case _005050 = '005050';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2008.
     */
    case _005051 = '005051';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2008.
     */
    case _005052 = '005052';

    /**
     * ASC X12 Standards Approved by ANSI in 2008.
     */
    case _006000 = '006000';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2008.
     */
    case _006010 = '006010';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2009.
     */
    case _006011 = '006011';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2009.
     */
    case _006012 = '006012';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2009.
     */
    case _006020 = '006020';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2010.
     */
    case _006021 = '006021';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2010.
     */
    case _006022 = '006022';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2010.
     */
    case _006030 = '006030';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2011.
     */
    case _006031 = '006031';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2011.
     */
    case _006032 = '006032';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2011.
     */
    case _006040 = '006040';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2012.
     */
    case _006041 = '006041';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2012.
     */
    case _006042 = '006042';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2012.
     */
    case _006050 = '006050';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2013.
     */
    case _006051 = '006051';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2013.
     */
    case _006052 = '006052';

    /**
     * ASC X12 Standards Approved by ANSI in 2013.
     */
    case _007000 = '007000';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2013.
     */
    case _007010 = '007010';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2014.
     */
    case _007011 = '007011';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2014.
     */
    case _007012 = '007012';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2014.
     */
    case _007020 = '007020';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2015.
     */
    case _007021 = '007021';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2015.
     */
    case _007022 = '007022';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2015.
     */
    case _007030 = '007030';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2016.
     */
    case _007031 = '007031';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2016.
     */
    case _007032 = '007032';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through October 2016.
     */
    case _007040 = '007040';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through February 2017.
     */
    case _007041 = '007041';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through June 2017.
     */
    case _007042 = '007042';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through December 2017.
     */
    case _007050 = '007050';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through April 2018.
     */
    case _007051 = '007051';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through August 2018.
     */
    case _007052 = '007052';

    /**
     * Standards Approved for Publication by ASC X12 Procedures Review Board through December 2018.
     */
    case _007060 = '007060';

    /**
     * 007061 Standards Approved for Publication by ASC X12 Procedures Review Board through April 2019.
     */
    case _007061 = '007061';

    /**
     * 007062 Standards Approved for Publication by ASC X12 Procedures Review Board through August 2019.
     */
    case _007062 = '007062';

    /**
     * ASC X12 Standards Approved by ANSI in 2019.
     */
    case _008000 = '008000';

    /**
     * 008010 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2019.
     */
    case _008010 = '008010';

    /**
     * 008020 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2020.
     */
    case _008020 = '008020';

    /**
     * 008030 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2021.
     */
    case _008030 = '008030';

    /**
     * 008040 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2022.
     */
    case _008040 = '008040';

    /**
     * 008050 Standards Approved for Publication by ASC X12 Procedures Review Board through December 2023.
     */
    case _008050 = '008050';
}
