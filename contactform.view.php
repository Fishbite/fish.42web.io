<section>
  <header class="intro">
    <h1 class="title-main"><?=$title?></h1>

    <p class="">Drop us a line...</p>
    <p class="">...we'll be right back to you</p>
  </header>
</section>

<section class="form-container">
  <form action="#" method="post">
    <fieldset id="userdetails">
      <legend>Your Details</legend>

      <label for="fname">first name</label>
      <input
        type="text"
        id="fname"
        name="fname"
        placeholder="first name"
        required
      />

      <label for="lname">last name</label>
      <input
        type="text"
        id="lname"
        name="lname"
        placeholder="last name"
        required
      />

      <label for="useremail">personal email address</label>
      <input
        type="email"
        id="useremail"
        name="useremail"
        placeholder="youremail@mailprovider.com"
        size="25"
        required
      />

      <label for="postcode">post code</label>
      <input type="text" name="postcode" placeholder="post code" required />
    </fieldset>

    <fieldset id="companydetails">
      <legend>company details (optional)</legend>

      <label for="cname">company name</label>
      <input type="text" id="cname" name="cname" placeholder="company name" />

      <label for="ctype">company type</label>

      <select name="ctype" id="ctype">
        <option value="">--please select a type--</option>

        <option value="sole-trader">sole trader</option>

        <option value="partnership">partnership</option>

        <option value="limited-company">limited company</option>

        <option value="limited-liability-partnership">
          limited liability partnership
        </option>

        <option value="public-limited-company">public limited company</option>

        <option value="unincorporated-association">
          unincorporated association
        </option>

        <option value="charitable-trust">charitable trust</option>

        <option value="charitable-incorporated-organisation">
          charitable incorporated organisation
        </option>

        <option value="company-limited-by-guarantee">
          company limited by guarantee
        </option>

        <option value="charitable company">charitable company</option>

        <option value="community-interest-company">
          community interest company
        </option>

        <option value="community-benefit-society">
          community benefit society
        </option>

        <option value="unincorporated-association">
          unincorporated association
        </option>

        <option value="other">other</option>
      </select>

      <label for="cemail">company email</label>
      <input
        type="email"
        name="cemail"
        id="cemail"
        placeholder="company.email@company.com"
      />
    </fieldset>

    <fieldset id="comments">
      <legend>any other comments</legend>

      <textarea
        name="comments"
        id="comments"
        rows="4"
        cols="35"
        placeholder="tell us or ask us anything else you have on your mind"
      ></textarea>
    </fieldset>

    <input type="submit" value="send my details" />
  </form>
</section>
