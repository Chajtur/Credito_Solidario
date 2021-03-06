<%@ Page Language="c#" %>
<%@ Import Namespace="Mvolo.DirectoryListing" %>
<%@ Import Namespace="System.Collections.Generic" %>
<%@ Import Namespace="System.IO" %>
<script runat="server">
void Page_Load()
{
    String path = null;
    String parentPath = null;
    int count = 0;
    String sortBy = Request.QueryString["sortby"];

    //
    // Databind to the directory listing
    //
    DirectoryListingEntryCollection listing =
        Context.Items[DirectoryListingModule.DirectoryListingContextKey] as DirectoryListingEntryCollection;

    if (listing == null)
    {
        throw new Exception("This page cannot be used without the DirectoryListing module");
    }

    //
    // Handle sorting
    //
    if (!String.IsNullOrEmpty(sortBy))
    {
        if (sortBy.Equals("name"))
        {
            listing.Sort(DirectoryListingEntry.CompareFileNames);
        }
        else if (sortBy.Equals("namerev"))
        {
            listing.Sort(DirectoryListingEntry.CompareFileNamesReverse);
        }
        else if (sortBy.Equals("date"))
        {
            listing.Sort(DirectoryListingEntry.CompareDatesModified);
        }
        else if (sortBy.Equals("daterev"))
        {
            listing.Sort(DirectoryListingEntry.CompareDatesModifiedReverse);
        }
        else if (sortBy.Equals("size"))
        {
            listing.Sort(DirectoryListingEntry.CompareFileSizes);
        }
        else if (sortBy.Equals("sizerev"))
        {
            listing.Sort(DirectoryListingEntry.CompareFileSizesReverse);
        }
    }

    DirectoryListing.DataSource = listing;
    DirectoryListing.DataBind();

    //
    //  Prepare the file counter label
    //
    FileCount.Text = listing.Count + " items.";

    //
    //
    //  Parepare the parent path label
    path = VirtualPathUtility.AppendTrailingSlash(Context.Request.Path);
    if (path.Equals("/") || path.Equals(VirtualPathUtility.AppendTrailingSlash(HttpRuntime.AppDomainAppVirtualPath)))
    {
        // cannot exit above the site root or application root
        parentPath = null;
    }
    else
    {
        parentPath = VirtualPathUtility.Combine(path, "..");
    }

    if (String.IsNullOrEmpty(parentPath))
    {
        NavigateUpLink.Visible = false;
        NavigateUpLink.Enabled = false;
    }
    else
    {
        NavigateUpLink.NavigateUrl = parentPath;
    }
}

String GetFileSizeString(FileSystemInfo info)
{
    if (info is FileInfo)
    {
        return String.Format("- {0}K", ((int)(((FileInfo)info).Length * 10 / (double)1024) / (double)10));
    }
    else
    {
        return String.Empty;
    }
}
</script>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Contenido del Directorio</title>
        <style type="text/css">
            a { text-decoration: none; }
            a:hover { text-decoration: underline; }
            p {font-family: verdana; font-size: 10pt; }
            h2 {font-family: verdana; }
            td {font-family: verdana; font-size: 10pt; }
        </style>
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
    </head>
    <body>
        <h2><asp:HyperLink runat="server" id="NavigateUpLink"></asp:HyperLink></h2>
        <p>
        <a href="?sortby=name">Ordenar por Nombre: </a>/<a href="?sortby=namerev">-</a> |
        <a href="?sortby=date">Ordenar por Fecha: </a>/<a href="?sortby=daterev">-</a> |
        <a href="?sortby=size">Ordenar por Tama�o: </a>/<a href="?sortby=sizerev">-</a>
        </p>
        <form runat="server">
            <hr/>
            <asp:DataList id="DirectoryListing" runat="server">
                <ItemTemplate>
                    <img alt="icon" src="<%=HttpRuntime.AppDomainAppVirtualPath %>/geticon.axd?file=<%# Path.GetExtension(((DirectoryListingEntry)Container.DataItem).Path) %>" />
                    <a href="<%# ((DirectoryListingEntry)Container.DataItem).VirtualPath  %>"><%# ((DirectoryListingEntry)Container.DataItem).Filename %></a>
                    &nbsp<%# GetFileSizeString(((DirectoryListingEntry)Container.DataItem).FileSystemInfo) %>
                </ItemTemplate>
            </asp:DataList>
            <hr />
            <p>
                <asp:Label runat="Server" id="FileCount" />
            </p>
        </form>



        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
    </body>
</html>
